## Pregunta N:5 Conteo Inicial
```
>>> ['users' => User::count(), 'categories' => Category::count(), 'notes' => Note::count(), 'note user' => Note::withCount('users')->get()->sum('users_count')]
= [
    "users" => 6,
    "categories" => 19,
    "notes" => 15,
    "note user" => 33,
  ]
```
**Respuesta / conclusión:** <texto breve>

## Pregunta N:6 Notas propias de un usuario
```
>>> $us = User::where('email', 'admin@uatf.bo')->first();
$us->notes()->wherePivot('role', 'owner')->pluck('title');  
=  all: [
      "Fugiat quis placeat suscipit vitae.",
      "Harum nihil sit.",
      "Necessitatibus vel.",
      "Est nobis ut.",
      "Quidem iusto iste est.",
      "Ipsa eum omnis voluptas.",
      "Dolorum et eveniet.",
      "Repellat voluptatem nemo.",
      "Perspiciatis consequuntur ut est.",
      "Sit tenetur architecto.",
      "Omnis iste quo architecto.",
      "Vel deleniti amet.",
      "Dolorem reprehenderit.",
      "Eos dolor labore.",
      "Quaerat officiis quidem quia necessitatibus.",
    ],
```
**Respuesta / conclusión:** <texto breve>

## Pregunta N:7 Compartir una nota
```
>>>$user = User::create(['name' => 'Colaborador Test','email' => 'test' . time() . '@mail.com','password' => bcrypt('password'),]);
$admin = User::where('email', 'admin@uatf.bo')->first();

$note = $admin->notes()->wherePivot('role', 'owner')->first();

$note->users()->attach($user->id, ['role' => 'editor']);

$note->users->map(fn($u) => ['name' => $u->name,'role' => $u->pivot->role]);
=  all: [
      [
        "name" => "Mertie Hartmann DVM",
        "role" => "editor",
      ],
      [
        "name" => "Admin",
        "role" => "owner",
      ],
      [
        "name" => "Colaborador Test",
        "role" => "editor",
      ],
    ],
```
**Respuesta / conclusión:** <texto breve>

## Pregunta N:8 Actualizar un rol en el pivote
```
>>> $note->users()->updateExistingPivot($user->id, ['role' => 'viewer']);
$note->load('users'); 
$note->users->map(fn($u) => ['name' => $u->name,'role' => $u->pivot->role]);
= all: [
      [
        "name" => "Mertie Hartmann DVM",
        "role" => "editor",
      ],
      [
        "name" => "Admin",
        "role" => "owner",
      ],
      [
        "name" => "Colaborador Test",
        "role" => "viewer",
      ],
    ],
```
**Respuesta / conclusión:** <texto breve>

## Pregunta N:9 Categorías más populares
```
>>> Category::withCount('notes')->orderByDesc('notes_count')->get(['name', 'notes_count']);
= all: [
      App\Models\Category {#8532
        id: 19,
        name: "assumenda sit",
        description: "At laborum voluptatibus at consequatur sequi nobis rerum cupiditate.",
        created_at: "2026-04-24 13:37:50",
        updated_at: "2026-04-24 13:37:50",
        notes_count: 1,
      },
      App\Models\Category {#8533
        id: 15,
        name: "odio accusamus",
        description: "Odit id labore quam omnis illum laboriosam.",
        created_at: "2026-04-24 13:37:50",
        updated_at: "2026-04-24 13:37:50",
        notes_count: 1,
      },
      App\Models\Category {#8530
        id: 16,
        name: "dolores occaecati",
        description: "Fugiat id facilis error et explicabo ab eligendi.",
        created_at: "2026-04-24 13:37:50",
        updated_at: "2026-04-24 13:37:50",
        notes_count: 1,
      },
      App\Models\Category {#8529
        id: 17,
        name: "cumque est",
        description: "Nemo culpa suscipit corrupti harum molestias illo.",
        created_at: "2026-04-24 13:37:50",
        updated_at: "2026-04-24 13:37:50",
        notes_count: 1,
      },
      App\Models\Category {#8528
        id: 18,
        name: "ut sapiente",
        description: "Sit ea non totam iste.",
        created_at: "2026-04-24 13:37:50",
        updated_at: "2026-04-24 13:37:50",
        notes_count: 1,
      },
      App\Models\Category {#8527
        id: 5,
        name: "quis ut",
        description: "Magnam sit itaque asperiores illum minima voluptates ut.",
        created_at: "2026-04-24 13:37:50",
        updated_at: "2026-04-24 13:37:50",
        notes_count: 1,
      },
      App\Models\Category {#8526
        id: 6,
        name: "porro sit",
        description: "Praesentium qui excepturi nam.",
        created_at: "2026-04-24 13:37:50",
        updated_at: "2026-04-24 13:37:50",
        notes_count: 1,
      },
      App\Models\Category {#8525
        id: 7,
        name: "voluptatem sint",
        description: "Quia deleniti et aut eligendi possimus laborum et et.",
        created_at: "2026-04-24 13:37:50",
        updated_at: "2026-04-24 13:37:50",
        notes_count: 1,
      },
      App\Models\Category {#8524
        id: 8,
        name: "quibusdam voluptate",
        description: "Asperiores reprehenderit possimus accusamus totam.",
        created_at: "2026-04-24 13:37:50",
        updated_at: "2026-04-24 13:37:50",
        notes_count: 1,
      },
      App\Models\Category {#8523
        id: 9,
        name: "omnis eius",
        description: "Necessitatibus reiciendis voluptatum esse sint.",
        created_at: "2026-04-24 13:37:50",
        updated_at: "2026-04-24 13:37:50",
        notes_count: 1,
      },
      App\Models\Category {#8522
        id: 10,
        name: "nam consequatur",
        description: "Odio aut omnis voluptatibus dolorem rerum est odio omnis.",
        created_at: "2026-04-24 13:37:50",
        updated_at: "2026-04-24 13:37:50",
        notes_count: 1,
      },
      App\Models\Category {#8521
        id: 11,
        name: "et neque",
        description: "Soluta est voluptas consequatur excepturi illum nihil.",
        created_at: "2026-04-24 13:37:50",
        updated_at: "2026-04-24 13:37:50",
        notes_count: 1,
      },
      App\Models\Category {#8520
        id: 12,
        name: "in eligendi",
        description: "Ea impedit est nobis et rerum velit.",
        created_at: "2026-04-24 13:37:50",
        updated_at: "2026-04-24 13:37:50",
        notes_count: 1,
      },
      App\Models\Category {#8519
        id: 13,
        name: "et animi",
        description: "Aliquam ab voluptates iste quam.",
        created_at: "2026-04-24 13:37:50",
        updated_at: "2026-04-24 13:37:50",
        notes_count: 1,
      },
      App\Models\Category {#8518
        id: 14,
        name: "perferendis quis",
        description: "Neque soluta ea maiores aut ratione illo.",
        created_at: "2026-04-24 13:37:50",
        updated_at: "2026-04-24 13:37:50",
        notes_count: 1,
      },
      App\Models\Category {#8517
        id: 2,
        name: "Estudio",
        description: "Estudio category",
        created_at: "2026-04-24 13:37:50",
        updated_at: "2026-04-24 13:37:50",
        notes_count: 0,
      },
      App\Models\Category {#8516
        id: 3,
        name: "Personal",
        description: "Personal category",
        created_at: "2026-04-24 13:37:50",
        updated_at: "2026-04-24 13:37:50",
        notes_count: 0,
      },
      App\Models\Category {#8515
        id: 4,
        name: "Ideas",
        description: "Ideas category",
        created_at: "2026-04-24 13:37:50",
        updated_at: "2026-04-24 13:37:50",
        notes_count: 0,
      },
      App\Models\Category {#8514
        id: 1,
        name: "Trabajo",
        description: "Trabajo category",
        created_at: "2026-04-24 13:37:50",
        updated_at: "2026-04-24 13:37:50",
        notes_count: 0,
      },
    ],
```
**Respuesta / conclusión:** <texto breve>

## Pregunta N:10 Notas públicas compartidas
```
>>> Note::where('is_public', true)->has('users', '>=', 2)->withCount('users')->get(['title', 'users_count']);
=  all: [
      App\Models\Note {#8702
        id: 1,
        title: "Eum velit quo et.",
        content: "Delectus occaecati aliquam assumenda laborum. Odio dicta labore nisi assumenda. Ex est vel unde molestias. Aut veniam officiis quod nostrum odit.",
        is_public: true,
        category_id: 5,
        created_at: "2026-04-24 13:37:50",
        updated_at: "2026-04-24 13:37:50",
        users_count: 2,
      },
      App\Models\Note {#8468
        id: 2,
        title: "Mollitia ea adipisci similique molestias.",
        content: "Eos dicta sint animi pariatur qui cum. Et et pariatur consectetur ut excepturi. Omnis autem et accusantium molestias et labore.",
        is_public: true,
        category_id: 6,
        created_at: "2026-04-24 13:37:50",
        updated_at: "2026-04-24 13:37:50",
        users_count: 2,
      },
      App\Models\Note {#8688
        id: 4,
        title: "Nihil est quia.",
        content: "Nisi minima voluptate maxime libero suscipit et. Voluptates dolore qui eum voluptas qui. Pariatur cum commodi eos et rerum eius.",
        is_public: true,
        category_id: 8,
        created_at: "2026-04-24 13:37:50",
        updated_at: "2026-04-24 13:37:50",
        users_count: 3,
      },
      App\Models\Note {#8692
        id: 7,
        title: "Quia pariatur.",
        content: "Aut temporibus neque ut dolorem velit. Ducimus veritatis exercitationem vero aut. Et ut blanditiis inventore qui nihil. Repudiandae veniam ut non sint magni at non. Quia repellendus pariatur quis.",
        is_public: true,
        category_id: 11,
        created_at: "2026-04-24 13:37:50",
        updated_at: "2026-04-24 13:37:50",
        users_count: 3,
      },
      App\Models\Note {#8695
        id: 12,
        title: "Et exercitationem libero fugit.",
        content: "Repudiandae eum culpa sint ea ducimus et. At laboriosam ut fuga quae eveniet eaque. Ullam sed autem tenetur. Qui illum amet velit odio quos.",
        is_public: true,
        category_id: 16,
        created_at: "2026-04-24 13:37:50",
        updated_at: "2026-04-24 13:37:50",
        users_count: 2,
      },
    ],
```
**Respuesta / conclusión:** <texto breve>

## Pregunta N:11 Usuario con más notas propias
```
>>>User::withCount(['notes as owned_notes_count' => fn($q) =>$q->where('note_user.role', 'owner')])->orderByDesc('owned_notes_count')->first(['name', 'email']);
= App\Models\User {#8704
    id: 6,
    name: "Admin",
    email: "admin@uatf.bo",
    email_verified_at: null,
    #password: "\$2y\$12\$skqS09/DRkh8cklagtTb6.kj4rQjLQVei48L0TRRnWKw0pJCYnvW.",
    #remember_token: null,
    created_at: "2026-04-24 13:37:50",
    updated_at: "2026-04-24 13:37:50",
    owned_notes_count: 15,
  }
```
**Respuesta / conclusión:** <texto breve>

## Pregunta N:12 Desvincular y verificar
```
>>> $note = Note::has('users', '>=', 3)->first();
// Antes
$note->users()->count();
= 3
// Elegir colaborador (no owner)
$collab = $note->users()->wherePivot('role', '!=', 'owner')->first();
// Eliminar
$note->users()->detach($collab->id);
// Después
$note->users()->count();
= 2
```
**Respuesta / conclusión:** <texto breve>

## Pregunta N:13 Eliminación en cascada
```
>>> $category = Category::has('notes')->first();

// Antes
['notes' => Note::count(),'note_user' => Note::withCount('users')->get()->sum('users_count'),];
= [
    "notes" => 15,
    "note_user" => 36,
  ]

// Eliminar categoría
$category->delete();

// Después
['notes' => Note::count(),'note_user' => Note::withCount('users')->get()->sum('users_count'),];
= [
    "notes" => 14,
    "note_user" => 34,
  ]
```
**Respuesta / conclusión:** <texto breve>