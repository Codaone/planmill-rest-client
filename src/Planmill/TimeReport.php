<?php
/**
 * Created by Tyotunnit.
 * User: Juhni
 * Date: 3.10.2015
 * Time: 10:44
 */

namespace codaone\Planmill;

class TimeReport {

	protected $id;
	protected $comment;
	protected $status;
	protected $amount;
	protected $taskId;
	protected $projectId;

	public function __construct(array $project) {
		$mapper = array(
			'id'        => 'TimeReport.Id',
			'comment'   => 'TimeReport.NormalComment',
			'status'    => 'TimeReport.Status',
			'amount'    => 'Amount',
			'taskId'    => 'TimerReport.TaskId',
			'projectId' => 'PMVProject.Id',
		);
		foreach ($mapper as $key => $map) {
			if (isset($project[$map])) {
				$this->$key = $project[$map];
			}
		}
	}

	/**
	 * @return int
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @return string
	 */
	public function getComment() {
		return $this->comment;
	}

	/**
	 * @return string
	 */
	public function getStatus() {
		return $this->status;
	}

	/**
	 * @return float
	 */
	public function getAmount() {
		return $this->amount;
	}

	/**
	 * @return int
	 */
	public function getTaskId() {
		return $this->taskId;
	}

	/**
	 * @return int
	 */
	public function getProjectId() {
		return $this->projectId;
	}
}