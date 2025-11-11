<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property int $id
 * @property string|null $image_path
 * @property bool $success
 * @property string|null $message
 * @property int|null $class
 * @property numeric|null $confidence
 * @property \Illuminate\Support\Carbon|null $request_timestamp
 * @property \Illuminate\Support\Carbon|null $response_timestamp
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AiAnalysisLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AiAnalysisLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AiAnalysisLog query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AiAnalysisLog whereClass($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AiAnalysisLog whereConfidence($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AiAnalysisLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AiAnalysisLog whereImagePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AiAnalysisLog whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AiAnalysisLog whereRequestTimestamp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AiAnalysisLog whereResponseTimestamp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AiAnalysisLog whereSuccess($value)
 */
	class AiAnalysisLog extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

