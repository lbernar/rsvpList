<?php

/**
 * @file
 * Provide site administrators with a list of all the RSVP List signups
 * so they know who is attending their events.
 */

 namespace Drupal\rsvplist\Controller;

 use Drupal\Core\Controller\ControllerBase;
 use Drupal\Core\Database\Database;

 class ReportController extends ControllerBase {
    /**
     * Gets and returns all RSVPs for all nodes.
     * These are returned as an associative array, with each row
     * containing the username, the node title, and email of RSVP.
     * 
     * @return array|null
     */
    protected function load() {
        try {
            $database = \Drupal::database();
            $selectQuery = $database->select('rsvplist', 'r');

            $selectQuery->join('users_field_data', 'u', 'r.uid = u.uid');
            $selectQuery->join('node_field_data', 'n', 'r.nid = n.nid');

            $selectQuery->addField('u', 'name', 'username');
            $selectQuery->addField('n', 'title');
            $selectQuery->addField('r', 'mail');

            $entries = $selectQuery->execute()->fetchAll(\PDO::FETCH_ASSOC);

            return $entries;
        }
        catch (\Exception $e) {
            \Drupal::messenger()->addStatus(t('Unable to access the database at this time. Please try again later.'. $e));
            return null;
        }
    }

    /**
     * Creates the RSVPList Report page.
     * 
     * @return array
     * Render array for the RSVPList report output.
     */
    public function report() {
        $content = [];
        $content['message'] = [
            '#markup' => t('Below is a list of all Events RSVPs including username, email address 
            and the name of the event they will be attending'),
        ];

        $headers = [
            t('Username'),
            t('Event'),
            t('Email'),
        ];

        $tableRows = $this->load();
        
        //Creates the render array for redering an HTML table.
        $content['table'] = [
            '#type' => 'table',
            '#header' => $headers,
            '#rows' => $tableRows,
            '#empty' => t('No entries available.'),
        ];

        //Do not cache this page by setting the max-age to 0.
        $content['#cache']['max-age'] = 0;

        return $content;
    }
 }