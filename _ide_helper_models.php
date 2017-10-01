<?php
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App{
/**
 * App\Article
 *
 * @property int $id
 * @property string $title
 * @property string $content
 * @property int $user_id
 * @property int $edit_user_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\User $author
 * @property-read \App\User $editor
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Article whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Article whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Article whereEditUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Article whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Article whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Article whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Article whereUserId($value)
 */
	class Article extends \Eloquent {}
}

namespace App{
/**
 * App\Donation
 *
 * @property int $id
 * @property int $donor_id
 * @property string $txn_id
 * @property float $fee
 * @property float $gross
 * @property string $status
 * @property string $type
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Donor $donor
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Donation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Donation whereDonorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Donation whereFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Donation whereGross($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Donation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Donation whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Donation whereTxnId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Donation whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Donation whereUpdatedAt($value)
 */
	class Donation extends \Eloquent {}
}

namespace App{
/**
 * App\Donor
 *
 * @property int $id
 * @property string $email
 * @property string $first_name
 * @property string $last_name
 * @property string|null $steam_id
 * @property string|null $ingame_name
 * @property string $payer_id
 * @property \Carbon\Carbon $expires_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Donation[] $donations
 * @property-read string $name
 * @property-read int $total_donated
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Donor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Donor whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Donor whereExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Donor whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Donor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Donor whereIngameName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Donor whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Donor wherePayerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Donor whereSteamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Donor whereUpdatedAt($value)
 */
	class Donor extends \Eloquent {}
}

namespace App{
/**
 * App\Group
 *
 * @property int $id
 * @property string $name
 * @property string $colour
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Permission[] $permissions
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $users
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Group whereColour($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Group whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Group whereName($value)
 */
	class Group extends \Eloquent {}
}

namespace App{
/**
 * App\Permission
 *
 * @property int $id
 * @property string $key
 * @property string $name
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Group[] $groups
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $users
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Permission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Permission whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Permission whereName($value)
 */
	class Permission extends \Eloquent {}
}

namespace App{
/**
 * App\User
 *
 * @property int $id
 * @property int $group_id
 * @property string $email
 * @property string $username
 * @property string $password
 * @property int $active
 * @property int $founder
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $remember_token
 * @property-read \App\Group $group
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Permission[] $permissions
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereFounder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUsername($value)
 */
	class User extends \Eloquent {}
}

