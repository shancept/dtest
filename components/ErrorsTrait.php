<?php


namespace app\components;


trait ErrorsTrait
{
	private $_errors;

	/**
	 * Returns a value indicating whether there is any validation error.
	 * @param string|null $attribute attribute name. Use null to check all attributes.
	 * @return bool whether there is any error.
	 */
	public function hasErrors($attribute = null): bool
	{
		return $attribute === null ? !empty($this->_errors) : isset($this->_errors[$attribute]);
	}

	/**
	 * Returns the errors for all attributes or a single attribute.
	 * @param null $attribute attribute name. Use null to retrieve errors for all attributes.
	 * @return array errors for all attributes or the specified attribute. Empty array is returned if no error.
	 * Note that when returning errors for all attributes, the result is a two-dimensional array, like the following:
	 *
	 * ```php
	 * [
	 *     'username' => [
	 *         'Username is required.',
	 *         'Username must contain only word characters.',
	 *     ],
	 *     'email' => [
	 *         'Email address is invalid.',
	 *     ]
	 * ]
	 * ```
	 *
	 * @property array An array of errors for all attributes. Empty array is returned if no error.
	 * The result is a two-dimensional array. See [[getErrors()]] for detailed description.
	 * @see getFirstErrors()
	 * @see getFirstError()
	 */
	public function getErrors($attribute = null): array
	{
		if ($attribute === null) {
			return $this->_errors ?? [];
		}

		return $this->_errors[$attribute] ?? [];
	}

	/**
	 * Returns the first error of every attribute in the model.
	 * @return array the first errors. The array keys are the attribute names, and the array
	 * values are the corresponding error messages. An empty array will be returned if there is no error.
	 * @see getErrors()
	 * @see getFirstError()
	 */
	public function getFirstErrors(): array
	{
		if (empty($this->_errors)) {
			return [];
		}

		$errors = [];
		foreach ($this->_errors as $name => $es) {
			if (!empty($es)) {
				$errors[$name] = reset($es);
			}
		}

		return $errors;
	}

	/**
	 * Returns the first error of the specified attribute.
	 * @param string $attribute attribute name.
	 * @return string|null the error message. Null is returned if no error.
	 * @see getErrors()
	 * @see getFirstErrors()
	 */
	public function getFirstError(string $attribute): ?string
	{
		return isset($this->_errors[$attribute]) ? reset($this->_errors[$attribute]) : null;
	}

	/**
	 * Returns the errors for all attributes as a one-dimensional array.
	 * @param bool $showAllErrors boolean, if set to true every error message for each attribute will be shown otherwise
	 * only the first error message for each attribute will be shown.
	 * @return array errors for all attributes as a one-dimensional array. Empty array is returned if no error.
	 * @see getErrors()
	 * @see getFirstErrors()
	 * @since 2.0.14
	 */
	public function getErrorSummary(bool $showAllErrors): array
	{
		$lines = [];
		$errors = $showAllErrors ? $this->getErrors() : $this->getFirstErrors();
		foreach ($errors as $es) {
			$lines = array_merge((array)$es, $lines);
		}
		return $lines;
	}

	/**
	 * Adds a new error to the specified attribute.
	 * @param string $attribute attribute name
	 * @param string $error new error message
	 */
	public function addError(string $attribute, $error = ''): void
	{
		$this->_errors[$attribute][] = $error;
	}

	/**
	 * Adds a list of errors.
	 * @param array $items a list of errors. The array keys must be attribute names.
	 * The array values should be error messages. If an attribute has multiple errors,
	 * these errors must be given in terms of an array.
	 * You may use the result of [[getErrors()]] as the value for this parameter.
	 * @since 2.0.2
	 */
	public function addErrors(array $items): void
	{
		foreach ($items as $attribute => $errors) {
			if (is_array($errors)) {
				foreach ($errors as $error) {
					$this->addError($attribute, $error);
				}
			} else {
				$this->addError($attribute, $errors);
			}
		}
	}

	/**
	 * Removes errors for all attributes or a single attribute.
	 * @param null $attribute attribute name. Use null to remove errors for all attributes.
	 */
	public function clearErrors($attribute = null): void
	{
		if ($attribute === null) {
			$this->_errors = [];
		} else {
			unset($this->_errors[$attribute]);
		}
	}

}