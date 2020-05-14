<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Questionnaire extends Model
{
    protected $table = 'Questionnaires';
    protected $fillable = [
      'questionnaire_name',
      'questionnaire_date_start',
      'questionnaire_date_end',
      'is_published'
    ];

    /**
  	 * Get excerpt from string
  	 *
  	 * @param String $str String to get an excerpt from
  	 * @param Integer $startPos Position int string to start excerpt from
  	 * @param Integer $maxLength Maximum length the excerpt may be
  	 * @return String excerpt
  	 */
  	public static function getExcerpt($str, $startPos = 0, $maxLength = 50)
    {
    		if(strlen($str) > $maxLength) {
            $excerpt   = substr($str, $startPos, $maxLength - 6);
            $lastSpace = strrpos($excerpt, ' ');
            $excerpt   = substr($excerpt, 0, $lastSpace);
            $excerpt  .= ' [...]';
    		} else {
            $excerpt = $str;
    		}

    		return $excerpt;
  	}
}
