<?php
/**
 * Created by Tyotunnit.
 * User: Juhni
 * Date: 3.10.2015
 * Time: 8:57
 */

namespace codaone\Planmill;

class Task {

	protected $id;
	protected $name;
	protected $created;
	protected $start;
	protected $finish;
	protected $billableStatus;
	protected $status;
	protected $type;

	public function __construct(array $project) {
		$mapper = array(
			'id'             => 'Id',
			'name'           => 'Task.Name',
			'created'        => 'Task.Created',
			'start'          => 'Task.Start',
			'finish'         => 'Task.Finish',
			'billableStatus' => 'Task.BillableStatus',
			'status'         => 'Task.Status',
			'type'           => 'Task.Type',
		);
		foreach ($mapper as $key => $map) {
			if (isset($project[$map])) {
				$this->$key = $project[$map];
			}
		}
	}

	/**
	 * @return mixed
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @return mixed
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @return mixed
	 */
	public function getCreated() {
		return $this->created;
	}

	/**
	 * @return mixed
	 */
	public function getStart() {
		return $this->start;
	}

	/**
	 * @return mixed
	 */
	public function getFinish() {
		return $this->finish;
	}

	/**
	 * @return mixed
	 */
	public function getBillableStatus() {
		return $this->billableStatus;
	}

	/**
	 * @return mixed
	 */
	public function getStatus() {
		return $this->status;
	}

	/**
	 * @return mixed
	 */
	public function getType() {
		return $this->type;
	}
}