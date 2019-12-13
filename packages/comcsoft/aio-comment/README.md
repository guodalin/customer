## AIO 评论组件

灵活的多态评论模块，包含前台和后台管理模块

### 安装

```
composer require comcsoft/aio-comment
```

运行 `php artisan migrate` 安装数据库迁移文件

运行 `php artisan comment:install` 安装必要的前后台数据

### 使用示例

Here are a few short examples of what you can do:

```php
use Comcsoft\Aio\Comment\CommentFacade;

CommentFacade::user($user)  // specific a user, authenticated user will be used if not called
    ->on($post) // commentable model
    ->at($comment) // reply to the comment model
    ->anonymous($bool)  // anonymous comment or not
    ->media($files)  // upload comment file
    ->message($message) // comment message
    ->save();   // save the comment
```

here are some help traits you can use
```php
// for user model
use Comcsoft\Aio\Comment\Traits\CanComment;

class User extend Model
{
    use CanComment;

    // ...
}

// add a comment
$user->commentOn($post)
    ->save($message);

// reply a comment
$user->commentAt($comment)
    ->message('thanks 4 sharing!')
    ->save();


// for commentable model, e.g. Post
use Comcsoft\Aio\Comment\Traits\CanCommentable;

$post->commentBy($user)
    ->save($message);
```

### 配置

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

and enjoy urself!
