<?php

namespace App\Http;

class Helpers{

	static function showModal($delete_text, $delete_small_text, $modal_id = "myModal", $action = "delete")
	{
		$modal = '<div id="'.$modal_id.'" class="modal fade">
		        <div class="modal-dialog">
		            <div class="modal-content">
		                <div class="modal-header">
		                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		                    <h4 class="modal-title">Confirmation</h4>
		                </div>
		                <div class="modal-body">
		                    <p>'.$delete_text.'</p>
		                    <p class="text-warning"><small>'.$delete_small_text.'</small></p>
		                </div>
		                <div class="modal-footer">
		                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';

		if($action == 'delete'){
			$modal .= '<button type="button" id="submit_modal_delete" class="btn btn-danger">Delete</button>';
		}elseif($action == 'confirm'){
			$modal .= '<button type="button" id="submit_modal_confirm" class="btn btn-primary ladda-button" data-style="expand-right">Ok</button>';
		}

		$modal .= '</div></div></div></div>';

		return $modal;
	}

	static function formActions($route){

		$buttons = '<div class="form-group">
					<div class="col-md-12 widget-right">
						<div class="pull-left col-md-offset-3">
							<a href="'.$route.'" title=""><button type="button" class="btn btn-danger">Cancel</button></a>
							<button type="submit" class="btn btn-primary ladda-button" data-style="expand-right">
								<span class="ladda-label">Save</span>
							</button>
						</div>
					</div>
				</div>';

		return $buttons;
	}

	static function formInput($col, $name, $type, $placeholder, $value = null)
	{
		$input = '<div class="form-group '.$col.'">
				<input class="form-control" type="'.$type.'" name="'.$name.'" id="'.$name.'" value="'.$value.'" placeholder="'.$placeholder.'">
			</div>';

		return $input;
	}

}