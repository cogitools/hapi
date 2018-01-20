<?php


namespace Harvest\Model;

/**
 * DayEntry
 *
 * This file contains the class DayEntry
 *
 */

/**
 * Harvest DayEntry Object
 *
 * @property int $id
 * @property int $project_id
 * @property int $task_id
 * @property int $user_id
 * @property float $hours
 * @property string $adjustment_record "true" or "false"
 * @property string $notes
 * @property string $created_at ISO Timestamp
 * @property string $updated_at ISO Timestamp
 * @property string|null $timer_started_at ISO Timestamp
 * @property string $spent_at ISO Date
 * @property string $is_billed "true" or "false"
 * @property string $is_closed "true" or "false"
 */
class DayEntry extends Harvest
{
    /**
     * @var string request
     */
    protected $_root = "request";

    /**
     * @var boolean convert underscore
     */
    protected $_convert = true;

}
