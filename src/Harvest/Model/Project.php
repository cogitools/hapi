<?php


namespace Harvest\Model;

/**
 * Project
 *
 * This file contains the class Project
 *
 */

/**
 * Harvest Project Object
 *
 * @property int $id
 * @property int $client_id
 * @property string $name
 * @property string $code
 * @property string $active "true" or "false"
 * @property string $active_task_assignments_count deprecated?
 * @property string $active_user_assignments_count deprecated?
 * @property string $basecamp_id deprecated?
 * @property string $bill_by
 * @property string $billable "true" or "false"
 * @property string $budget
 * @property string $budget_by
 * @property string $cache_version deprecated?
 * @property string $cost_budget
 * @property string $cost_budget_include_expenses "true" or "false"
 * @property string $created_at ISO timestamp
 * @property string $updated_at ISO timestamp
 * @property string $starts_on ISO timestamp
 * @property string $ends_on ISO timestamp
 * @property string $fees deprecated?
 * @property string $highrise_deal_id deprecated?
 * @property string $hourly_rate
 * @property string $notify_when_over_budget "true" or "false"
 * @property float $over_budget_notification_percentage
 * @property string $over_budget_notified_at
 * @property string $show_budget_to_all "true" or "false"
 * @property string $estimate
 * @property string $estimate_by
 * @property string $is_fixed_fee "true" or "false"
 * @property string $hint_earliest_record_at "true" or "false"
 * @property string $hint_latest_record_at "true" or "false"
 * @property string $notes
 */
class Project extends Harvest
{
    /**
     * @var string project
     */
    protected $_root = "project";

    /**
     * @var array Tasks
     */
    protected $_tasks = array();

    /**
     * get specifed property
     *
     * @param  mixed $property
     * @return mixed
     */
    public function get($property)
    {
        if ($property == "tasks") {
            return $this->_tasks;
        } else {
            return parent::get($property);
        }

    }

    /**
     * set property to specified value
     *
     * @param  mixed $property
     * @param  mixed $value
     * @return void
     */
    public function set($property, $value)
    {
        if ($property == "tasks") {
            $this->_tasks = $value;
        } else {
            parent::set($property, $value);
        }
    }

    /**
     * parse XML representation into a Harvest Project object
     *
     * @param  \DOMNode $node xml node to parse
     * @return void
     */
    public function parseXml($node)
    {
        foreach ($node->childNodes as $item) {
            switch ($item->nodeName) {
                case "tasks":
                    $this->_tasks = $this->parseItems( $item );
                break;
                default:
                    if ($item->nodeName != "#text") {
                        $this->set( $item->nodeName, $item->nodeValue);
                    }
                break;
            }
        }

    }

    /**
     * parse xml list
     * @param  \DOMNode $xml
     * @return array
     */
    private function parseItems($xml)
    {
        $items = array();

        foreach ($xml->childNodes AS $item) {
            $item = $this->parseNode( $item );
            if ( ! is_null( $item ) ) {
                $items[$item->id()] = $item;
            }
        }

        return $items;

    }

    /**
     * parse xml node
     * @param  \DOMNode $node
     * @return mixed
     */
    private function parseNode($node)
    {
        $item = null;

        switch ($node->nodeName) {
            case "task":
                $item = new Task();
            break;
            default:
            break;
        }
        if ( ! is_null( $item ) ) {
            $item->parseXml( $node );
        }

        return $item;

    }

}
