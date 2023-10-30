<?php

/**
 * @file
 * RSVP List Service Enabler
 */

 namespace Drupal\rsvplist;

 use Drupal\Core\Database\Connection;
 use Drupal\node\Entity\Node;

 class EnablerService {
    protected $databaseConnection;

    public function __construct(Connection $connection)
    {
        $this->databaseConnection = $connection;
    }

    /**
     * Check if an individual node is RSVP enabled.
     * 
     * @param Node $node
     * @return bool
     * whether or not the node is enabled for the RSVP functinality.
     */
    public function isEnabled(Node &$node) {
        if ($node->isNew()) {
            return false;
        }

        try {
            $select = $this->databaseConnection->select('rsvplist_enabled', 're');
            $select->fields('re', ['nid']);
            $select->condition('nid', $node->id());
            $results = $select->execute();

            return !(empty($results->fetchCol()));
        }
        catch (\Exception $e) {
            \Drupal::messenger()->addError(t('Unable to determine RSVP settings at this time. Please try again'.$e));
            return null;
        }
    }

    /** 
     * Sets an idividual node to be RSVP enabled.
     * 
     * @param Node $node
     * @throws Exception 
     */
    public function setEnabled(Node $node) {
        try {
            if (!($this->isEnabled($node))) {
                $insert = $this->databaseConnection->insert('rsvplist_enabled');
                $insert->fields(['nid']);
                $insert->values([$node->id()]);
                $insert->execute();
            }
        }
        catch (\Exception $e) {
            \Drupal::messenger()->addError(t('Unable to save RSVP settings at this time. Please try again' . $e));
        }
    }

    /** 
     * Delete RSVP enabled settings for an individual node.
     * 
     * @param Node $node
     */
    public function delEnabled(Node $node) {
        try {
                $delete = $this->databaseConnection->delete('rsvplist_enabled');
                $delete->condition('nid', $node->id());
                $delete->execute();
        }
        catch (\Exception $e) {
            \Drupal::messenger()->addError(t('Unable to save RSVP settings at this time. Please try again' . $e));
        }
    }


 }