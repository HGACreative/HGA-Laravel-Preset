<?php

namespace App\Traits;
use Exception;

/**
 * Automatically associate a persisted record with
 * the currently authenticated user. This trait assumes
 * normal Laravel foreign key naming conventions are
 * adhered to, in as much the "App\Models\User" id column
 * is referenced as a foreign key under "user_id"
 *
 */
trait AutomateAuthUserAssociation {

    /**
	 * Hook onto the boot method
	 *
	 * @return void
	 */
	protected static function bootAutomateAuthUserAssociation()
	{
		/**
		 * When creating a new entry for a model automatically
		 * associate the model with the authenticated user
		 */
		static::creating(function($model) {

			try {

				$model->user_id = auth()->user()->id;

            } catch(Exception $e) {

                $model->user_id = $model->user_id;

            }

		});
	}
}
