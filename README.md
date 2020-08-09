# Sortlandbloggen

- [Framework and components used](#framework)
- [Tasks](#tasks)
- [Solution](#solution)
- [Demo](#demo)
- [Installation](#installation)

## Frameworks and components used:
<a name="framework"></a>
- [Laravel](https://github.com/laravel/laravel) v7.23.2
- [Vue](https://github.com/vuejs/vue) v2.5.17
- [crip-vue-notice](https://www.npmjs.com/package/crip-vue-notice) v1.1.1
- [laravel-vue-pagination](https://github.com/gilbitron/laravel-vue-pagination) v2.3.1
- [vue-moment](https://www.npmjs.com/package/vue-moment) v4.1.0

## Tasks 
<a name="tasks"></a>
- Login page
- List of posts
- A user should only be able to access the page after logging in.
- User logging in properly with the correct validation.
- 'List page' should contain the following:
    - Table of all posts. Columns should be 'title', 'date_created' and action button.  
    - 'New post' button above the table that triggers a modal containing the form
- The form should contain 'title' + 'post'
- Action button should be a dropdown button with 'edit' and 'delete'.
- Edit button should open the same modal as 'new'
- Delete should be triggered after a confirmation. (Are you sure yes/no)
- The changes made in this list should be reactive. Creating a new post should add a row in the table without a page refresh. The same with edit/delete.
- Clicking the 'title' in the table should open a 'details modal' showing the post.
- Bonus: Making users with read only access

## Solution
<a name="solution"></a>
For the user part I used Laravel's [built in user system](https://laravel.com/docs/7.x/authentication), and used [Laravel Sanctum](https://laravel.com/docs/7.x/sanctum) for authentication, to easily have a usable user database with register/login with validation. User model has an extra "read_only" boolean column wich defaults to 0, not read only used. One must choose on the [registration page](resources/views/auth/register.blade.php).

The [routes](routes/web.php) for the Post controllers functions that needs authentication are protected by Sanctum middleware.   

The [List post page (Posts)](resources/js/components/posts/PostsListComponent.vue) lists all posts by current logged in user. If the user is not read only, it displays an "New post" button, and an Action dropdown button with Edit and Delete. 

Delete button has an confirmation modal.

'New' and 'edit post' uses same modal, wich either is a clear form or gets injected with the excisting post for edit. Form contains 'title' and 'post'. Navigation tab Posts only appear if user is not read only. The posts page is still visitable for read only users however, the thought being that it might be a user who got his write access revoked, but still had old posts. 

Changes made in the list are reactive. For every action, the changed list is sent back and repopulated on page without page refresh.

Clicking on post title will open a preview modal. Also added a permalink next to title, wich links to public post page.

Posts have a [controller](app/Http/Controllers/PostController.php) and [model](app/Post.php). Added database relations to User model for posts and reverse relation [Post](app/Post.php) to [User](app/User.php). A post belongs to User, and User has many posts. 

## Demo
<a name="demo"></a>
Working demo can be found on [https://ekstremedia.no/sortlandbloggen/public](https://ekstremedia.no/sortlandbloggen/public)

It has two users already: 

Mr Read Only
- email: read@only.email
- password: readonly

Mr Normal Account
- email: normal@account.no
- password: normalaccount
## Installation
<a name="installation"></a>

Clone [repository](https://github.com/ekstremedia/sortlandbloggen) with Git.
```
git clone https://github.com/ekstremedia/sortlandbloggen sortlandbloggen
```
Change into cloned folder
```
cd sortlandbloggen
````
Install Laravel components via composer:
```
composer install
```
Install NodeJS components:
```
npm install
```
Compile Vue scripts
```
npm run prod
```
Edit database section in [.env](.env) file:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tablename
DB_USERNAME=username
DB_PASSWORD=password
```
Generate your application encryption key
```
php artisan key:generate
```
Run Laravel migrations to add the tables to database
```
php artisan migrate
```