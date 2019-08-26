## Laravel Comment

Add comment in your laravel project.

Here are a few short examples of what you can do:

```php
// add a comment
$user->addComment($post, 'that is great!');
$post->addComment('its nice!');

// reply a comment
$user->addComment($post, 'thanks 4 sharing!', null, false, $comment);
$post->addComment('nice job!', null, false, $comment);
$comment->addReply('so far so good!');

// get comments paginator list for a post
// root only with all of its replies.
$post->commentsPaginate();
```

And u can attach one or mulitple images or videos in your comments

```php
$user->addComment($post, 'that is great!', ['fileName', 'anotherFileName']);
$post->addComment('its nice!', 'fileName');
$comment->addReply('so far so good!', 'fileName');
```

You can set anonymous to true if you are shy when posting a comment

```php
$user->addComment($post, 'that is great!', 'fileName', true);
$post->addComment('its nice!', 'fileName', true);
$comment->addReply('so far so good!', 'fileName', null, true);
```

And you can specify a commenter if you dont want to use the current user

```php
$post->addComment('its nice!', 'fileName', true, null, $user);
$comment->addReply('so far so good!', 'fileName', $user);
```

### Install

~~~
composer require comcsoft/laravel-comment
~~~

Add `CommentServiceProvider` in `app/config/app.php` if you are using laravel <= 5.4

```php
'providers' => [
    'Comcsoft\Comment\CommentServiceProvider'
]
```

Run `php artisan vendor:publish --tag=laravel-comment` to publish config file.

```php
return [
    // Commenter settings
    'commenter' => [
        'cascade_on_delete' => false,

        'table' => [
            'name' => 'users',
            'primary_key' => 'id',
        ],

        'model' => env('COMMENT_COMMENTER_MODEL', config('auth.providers.users.model')),
    ],

    // comments media settings
    'media' => [
        'thumb' => [
            'width' => env('COMMENT_MEDIA_THUMB_WIDTH', 200),
            'height' => env('COMMENT_MEDIA_THUMB_HEIGHT', 200),
        ],
    ],

    // comment model, you can use ur own comment model here
    'model' => env('COMMENT_MODEL', Comcsoft\Comment\Models\Comment::class)
];
```
Run `php artisan migrate` to create comment table

Add trait to User Model class to make it as a commenter

```php
use Comcsoft/Comment/Traits/CanComment;

class User extends Model
{
    use CanComment;
}
```

Add Commentable Trait to Models where to leave a comment

```php
use Comcsoft/Comment/Traits/HasComments;

class Post extends Model
{
    use HasComments;
}
```

and enjoy urself!
