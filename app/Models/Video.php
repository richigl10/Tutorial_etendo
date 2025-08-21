<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Video
 *
 * @property int $id
 * @property string $title
 * @property string|null $description
 * @property string $path
 * @property string|null $pdf_path
 * @property int $order
 * @property bool $completed
 * @property int $module_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Module $module
 *
 * @package App\Models
 */
class Video extends Model
{
	protected $connection = 'mysql';
	protected $table = 'videos';

	protected $casts = [
		'order' => 'int',
		'completed' => 'bool',
		'module_id' => 'int'
	];

	protected $fillable = [
		'title',
		'description',
		'path',
		'pdf_path',
		'order',
		'completed',
		'module_id'
	];

	public function module()
	{
		return $this->belongsTo(Module::class);
	}

    public function completedByUsers()
    {
        return $this->belongsToMany(User::class, 'user_video')->withTimestamps();
    }

}
