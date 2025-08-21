<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Module
 * 
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $description
 * @property int $order
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Video[] $videos
 *
 * @package App\Models
 */
class Module extends Model
{
	protected $connection = 'mysql';
	protected $table = 'modules';

	protected $casts = [
		'order' => 'int'
	];

	protected $fillable = [
		'name',
		'slug',
		'description',
		'order'
	];

	public function videos()
	{
		return $this->hasMany(Video::class);
	}
}
