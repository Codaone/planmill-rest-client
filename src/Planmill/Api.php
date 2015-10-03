<?php
/*
 * The MIT License
 *
 * Copyright (c) 2014 Shuhei Tanuma
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */
namespace codaone\Planmill;

use codaone\Planmill\Api\Authentication\AuthenticationInterface;
use codaone\Planmill\Api\Client\ClientInterface;
use codaone\Planmill\Api\Result;
use codaone\Planmill\Api\Client\CurlClient;

class Api {
	const REQUEST_GET = "GET";
	const REQUEST_POST = "POST";
	const REQUEST_PUT = "PUT";
	const REQUEST_DELETE = "DELETE";

	const AUTOMAP_FIELDS = 0x01;

	/** @var string $endpoint */
	protected $endpoint;

	/** @var ClientInterface */
	protected $client;

	/** @var AuthenticationInterface */
	protected $authentication;

	/** @var int $options */
	protected $options = self::AUTOMAP_FIELDS;

	/** @var array $fields */
	protected $fields;

	/** @var array $priority */
	protected $priorities;

	/** @var array $status */
	protected $statuses;

	/**
	 * create a jira api client.
	 *
	 * @param                         $endpoint
	 * @param AuthenticationInterface $authentication
	 * @param ClientInterface         $client
	 */
	public function __construct(
		$endpoint,
		AuthenticationInterface $authentication,
		ClientInterface $client = NULL
	) {
		$this->authentication = $authentication;
		$this->setEndPoint($endpoint);

		if (is_null($client)) {
			$client = new CurlClient();
		}

		$this->client = $client;
	}

	public function setOptions($options) {
		$this->options = $options;
	}

	/**
	 * get endpoint url
	 *
	 * @return mixed
	 */
	public function getEndpoint() {
		return $this->endpoint;
	}

	/**
	 * set end point url.
	 *
	 * @param $url
	 */
	public function setEndPoint($url) {
		$this->fields = array();

		$this->endpoint = $url . "services/rest?format=rest" .
			"&userid=" . $this->authentication->getId() .
			"&authkey=" . $this->authentication->getAuthkey() . "&";
	}

	public function getUser($firstname, $lastname) {
		return $this->api(
			self::REQUEST_GET,
			"method=user.get" .
			"&Person.FirstName=$firstname&Person.LastName=$lastname"
		);
	}

	/**
	 * @param int      $projectId
	 * @param int|null $taskId
	 * @return Task[]
	 */
	public function getTasks($projectId, $taskId = NULL) {
		return $this->api(
			self::REQUEST_GET,
			"method=task.get" .
			"&TaskHierarchy.ProjectId=$projectId" .
			"&Task.Id=$taskId"
		)->getTasks((bool)$taskId);
	}

	/**
	 * @param int|null $projectId
	 * @return Project[]
	 */
	public function getProjects($projectId = NULL) {
		return $this->api(
			self::REQUEST_GET,
			"method=project.get" .
			($projectId ? "&PMVProject.Id=$projectId" : "")
		)->getProjects((bool)$projectId);
	}

	public function getTimeReports($timereporId = null) {
		return $this->api(
			self::REQUEST_GET,
			"&method=timereport.get" .
			($timereporId ? "&TimeReport.Id=$timereporId" : '')
		)->getTimeReports((bool)$timereporId);
	}

	public function reportHours($taskId, $amount, $comment) {
		return $this->api(
			self::REQUEST_GET,
			"&method=timereport.insert" .
			"&TimeReport.Amount=$amount" .
			"&TimeReport.NormalComment=" . urlencode($comment) .
			"&TimeReport.PersonId=" . $this->authentication->getId() .
			"&TimeReport.TaskId=$taskId" .
			"&return=true"
		);
	}

	public function editReportHours($reportId, $amount, $comment) {
		return $this->api(
			self::REQUEST_GET,
			"&method=timereport.update" .
			"&TimeReport.Id=$reportId" .
			"&TimeReport.Amount=$amount" .
			"&TimeReport.NormalComment=" . urlencode($comment) .
			"&TimeReport.PersonId=" . $this->authentication->getId() .
			"&return=true"
		);
	}

	/**
	 * send request to specified host
	 *
	 * @param string $method
	 * @param        $url
	 * @param array  $data
	 * @param bool   $return_as_json
	 * @return Result
	 */
	public function api(
		$method = self::REQUEST_GET,
		$url,
		$data = array(),
		$return_as_json = FALSE,
		$debug = FALSE
	) {
		$result = $this->client->sendRequest(
			$method,
			$url,
			$data,
			$this->getEndpoint(),
			$this->authentication,
			$debug
		);

		if (strlen($result)) {
			return new Result($result);
		}
		else {
			return FALSE;
		}
	}
}
