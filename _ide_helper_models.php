<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Note
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $body
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\NoteFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Note newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Note newQuery()
 * @method static \Illuminate\Database\Query\Builder|Note onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Note public()
 * @method static \Illuminate\Database\Eloquent\Builder|Note query()
 * @method static \Illuminate\Database\Eloquent\Builder|Note whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Note whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Note whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Note whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Note whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Note whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Note whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|Note withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Note withoutTrashed()
 */
	class Note extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $username
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property int|null $parent_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection|User[] $children
 * @property-read int|null $children_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Note[] $notes
 * @property-read int|null $notes_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read User|null $parent
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection|static[] all($columns = ['*'])
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|User breadthFirst()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|User depthFirst()
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection|static[] get($columns = ['*'])
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|User getExpressionGrammar()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|User hasChildren()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|User hasParent()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|User isLeaf()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|User isRoot()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|User newModelQuery()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Query\Builder|User onlyTrashed()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|User query()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|User tree($maxDepth = null)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|User treeOf(callable $constraint, $maxDepth = null)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|User whereDeletedAt($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|User whereDepth($operator, $value = null)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|User whereEmail($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|User whereId($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|User whereName($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|User whereParentId($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|User wherePassword($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|User whereUsername($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|User withGlobalScopes(array $scopes)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|User withRelationshipExpression($direction, callable $constraint, $initialDepth, $from = null, $maxDepth = null)
 * @method static \Illuminate\Database\Query\Builder|User withTrashed()
 * @method static \Illuminate\Database\Query\Builder|User withoutTrashed()
 */
	class User extends \Eloquent {}
}

