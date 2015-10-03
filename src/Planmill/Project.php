<?php
/**
 * Created by Tyotunnit.
 * User: Juhni
 * Date: 3.10.2015
 * Time: 8:57
 */

namespace codaone\Planmill;

class Project {

	protected $id;
	protected $name;
	protected $finish;
	protected $billableStatus;
	protected $accountName;
	protected $status;

	public function __construct(array $project) {
		$mapper = array(
			'id'             => 'PMVProject.Id',
			'name'           => 'MVProject.PureName',
			'finish'         => 'PMVProject.Finish',
			'billableStatus' => 'MVProject.BillableStatus',
			'status'         => 'PMVProject.Status',
			'accountName'    => 'Account.Name',
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
	public function getAccountName() {
		return $this->accountName;
	}

	/**
	 * @return mixed
	 */
	public function getStatus() {
		return $this->status;
	}
}