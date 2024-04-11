<?php

interface iType {

	public function validate(): bool;

	public function getName(): string;

	public function getError(): string;
}
