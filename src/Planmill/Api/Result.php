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
namespace codaone\Planmill\Api;

use codaone\Planmill\Project;
use codaone\Planmill\Task;

class Result {
	protected $expand;
	protected $startAt;
	protected $maxResults;
	protected $total;

	protected $result;

	public function __construct($result) {
		$this->result = simplexml_load_string($result);
		$this->result = json_encode($this->result);
		$this->result = json_decode($this->result, true);
	}

	public function getTotal() {
		return $this->total;
	}



	public function getProjects() {
		if (isset($this->result['projects']['project'])) {
			$result = array();
			foreach ($this->result['projects']['project'] as $data) {
				$result[] = new Project($data);
			}
			return $result;
		}
	}

	public function getTasks() {
		if (isset($this->result['tasks']['task'])) {
			$result = array();
			foreach ($this->result['tasks']['task'] as $data) {
				$result[] = new Task($data);
			}
			return $result;
		}
	}

	public function getResult() {
		return $this->result;
	}
}