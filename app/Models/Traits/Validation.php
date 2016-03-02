<?php namespace App\Models\Traits;

use Illuminate\Support\Facades\Validator;


/**
 * Trait ValidationModel
 * @package App\Models
 */
trait Validation {

  /**
   * @var
   */
  private $validationErrors = [];

  /**
   * @param $data
   * @return bool
   */
  public function validate($data)
  {
    $v = Validator::make($data, $this->validationRules);

    if ($v->fails())
    {
      $this->validationErrors = $v->errors();
      return false;
    }

    return true;
  }

  /**
   * @return mixed
   */
  public function getValidationErrors()
  {
    return $this->validationErrors;
  }
}