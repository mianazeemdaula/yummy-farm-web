<?php

namespace App\GraphQL\Queries;

use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use App\Models\User;
use Grimzy\LaravelMysqlSpatial\Types\Point;


class NearestSellers
{
    /**
     * Return a value for the field.
     *
     * @param  @param  null  $root Always null, since this field has no parent.
     * @param  array<string, mixed>  $args The field arguments passed by the client.
     * @param  \Nuwave\Lighthouse\Support\Contracts\GraphQLContext  $context Shared between all fields.
     * @param  \GraphQL\Type\Definition\ResolveInfo  $resolveInfo Metadata for advanced query resolution.
     * @return mixed
     */
    public function __invoke($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $users = User::query();

        if(isset($args['role'])){
            $users->where('role', $args['role']);
        }
        if(isset($args['lat']) && isset($args['lng'])){
            $point = new Point($args['lat'], $args['lng']);
            $users->distanceSphere('location', $point, 5000);
        }

        return $users->get();
    }
}
