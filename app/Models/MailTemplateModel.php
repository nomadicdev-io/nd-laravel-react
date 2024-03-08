<?php

namespace App\Models;

use App\Traits\DataTrait;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class MailTemplateModel extends Model {

	use Sluggable, DataTrait;

	protected $table = 'mail_templates';
	protected $primaryKey = 'mt_id';

	protected $fillable = [
		'mt_title',
		'mt_slug',
		'mt_subject',
		'mt_subject_arabic',
		'mt_template',
		'mt_template_arabic',
	];

	public function sluggable(): array {
		return [
			'mt_slug' => [
				'source' => 'mt_title',
			],
		];
	}

	public function getTitle() {
		return $this->getData('mt_title');
	}

	public function getSubject() {
		return $this->getData('mt_subject');
	}

	public function getTemplate() {
		return $this->getData('mt_template');
	}

	const CREATED_AT = 'mt_created_at';
	const UPDATED_AT = 'mt_updated_at';
}
