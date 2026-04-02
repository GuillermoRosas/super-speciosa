<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Super Speciosa Technical Assessment

## Part 1 — Debug & Review
Below is a simplified controller currently used in production.
````php
class LeadController extends Controller
{
public function index()
{
$leads = DB::table('leads')->get();

       foreach ($leads as $lead) {
           $lead->user = DB::table('users')
               ->where('id', $lead->assigned_user_id)
               ->first();
       }

       return response()->json($leads);
}
}
````
Questions
Answer the following:
What performance problem exists in this code?

R: The performance problem in the provided code is that it retrieves all leads from the database and then performs a separate query to fetch the assigned user for each lead. This results in an N+1 query problem, where N is the number of leads. As the number of leads grows, the number of database queries increases linearly, leading to significant performance degradation. For example, if there are 1,000,000 leads, the code will execute 1,000,001 database queries, which is highly inefficient. To address this issue, we can use eager loading to fetch all the necessary data in a single query, thereby reducing the number of database interactions and improving overall performance. In Laravel, this can be achieved by using the `with` method when retrieving the leads, as shown in the revised code snippet below:

in other hand, use models and relationships. Boost provides your agent 15+ tools and skills that help agents build Laravel applications while following best practices.

How would you fix it in Laravel?

R: To fix the performance issue in Laravel, you can use the `with` or `load` method to eager load the `assignedUser` relationship when retrieving the leads. This will reduce the number of database queries from N+1 to 2, where N is the number of leads.
Using models and relationships. First, ensure that you have defined the relationship in your Lead model:
```php
$leads = Lead::all()->load('assignedUser');
```

If the table grows to 1M leads, what database changes would you consider?

R: If the table grows to 1M leads, you would consider implementing the following database changes:
- Indexing: Ensure that the `assigned_user_id` column in the `leads` table is indexed. This will speed up the join operation when fetching the assigned user.
- Partitioning: If the `leads` table grows very large, consider partitioning the table based on a relevant column (e.g., `created_at` or `id`). This can help improve query performance by reducing the amount of data that needs to be scanned.
- Query Optimization: Optimize the queries to minimize the amount of data retrieved from the database. For example, if you don't need all columns from the `users` table, specify only the necessary columns in the query.
- Caching: Implement caching mechanisms to reduce the number of database queries. For example, cache the result of the `index` method and invalidate the cache when the data changes.
- Hardware Upgrades: Consider upgrading the hardware, such as adding more RAM or using faster storage, to handle the increased load on the database server.

## Part 2 — Data Modeling (15 minutes)
We want to add a feature:
Sales reps should be able to add notes to a lead.
Example:
Lead: Green Earth Market

Notes:
- Called buyer, interested in organic line
- Wants wholesale pricing sheet
  Task
  Design the database schema for this feature.
  Provide:
  Table structure, Indexes, Laravel migration


Example format:
lead_notes
````text
id
lead_id
user_id
note
created_at
````
Also answer:

How would you query the latest note for each lead efficiently?

R: To query the latest note for each lead efficiently, you can use a subquery or a join with a window function to get the most recent note for each lead. Here is an example using a subquery:
Or using the laravel tools:
```php
 public function latestNote()
    {
        return $this->hasOne(LeadNote::class)->latestOfMany();
    }
```

## Part 3 — Feature Implementation
Spin up a laravel application for this and include it in your submission.
Implement an API endpoint:
POST /api/leads/{lead}/notes
Example request:
{
"note": "Buyer wants to review wholesale pricing."
}
Requirements:
Save the note


Associate with logged-in user


Return the created note


Expected pieces:
Model


Migration


Controller method


Validation


You do not need to build authentication.
Assume Auth::user() exists.
