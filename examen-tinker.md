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

**Respuesta / conclusión:**
Se obtuvieron correctamente los conteos de todas las entidades. La tabla pivote refleja la cantidad total de relaciones entre usuarios y notas, lo que confirma que las asociaciones N:M están funcionando correctamente.

---

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
]
```

**Respuesta / conclusión:**
Se filtraron correctamente las notas donde el usuario tiene rol `owner`. Esto demuestra el uso adecuado de `wherePivot` en relaciones muchos a muchos.

---

## Pregunta N:7 Compartir una nota

```
>>> $user = User::create(['name' => 'Colaborador Test','email' => 'test' . time() . '@mail.com','password' => bcrypt('password'),]);
$admin = User::where('email', 'admin@uatf.bo')->first();

$note = $admin->notes()->wherePivot('role', 'owner')->first();

$note->users()->attach($user->id, ['role' => 'editor']);

$note->users->map(fn($u) => ['name' => $u->name,'role' => $u->pivot->role]);
=  all: [
    ["name" => "Mertie Hartmann DVM","role" => "editor"],
    ["name" => "Admin","role" => "owner"],
    ["name" => "Colaborador Test","role" => "editor"],
]
```

**Respuesta / conclusión:**
Se agregó correctamente un nuevo usuario como colaborador mediante la tabla pivote, asignándole el rol `editor`. Esto confirma el uso correcto de `attach()` con datos adicionales.

---

## Pregunta N:8 Actualizar un rol en el pivote

```
>>> $note->users()->updateExistingPivot($user->id, ['role' => 'viewer']);
$note->load('users'); 
$note->users->map(fn($u) => ['name' => $u->name,'role' => $u->pivot->role]);
= all: [
    ["name" => "Mertie Hartmann DVM","role" => "editor"],
    ["name" => "Admin","role" => "owner"],
    ["name" => "Colaborador Test","role" => "viewer"],
]
```

**Respuesta / conclusión:**
Se actualizó correctamente el rol del colaborador en la tabla pivote. Fue necesario recargar la relación para reflejar los cambios, evidenciando el manejo de caché en Eloquent.

---

## Pregunta N:9 Categorías más populares

```
>>> Category::withCount('notes')->orderByDesc('notes_count')->get(['name', 'notes_count']);
```

**Respuesta / conclusión:**
Las categorías fueron ordenadas correctamente según la cantidad de notas asociadas. Se utilizó `withCount` para calcular dinámicamente el número de relaciones, lo cual es eficiente y adecuado.

---

## Pregunta N:10 Notas públicas compartidas

```
>>> Note::where('is_public', true)->has('users', '>=', 2)->withCount('users')->get(['title', 'users_count']);
```

**Respuesta / conclusión:**
Se obtuvieron correctamente las notas públicas que tienen al menos dos usuarios asociados. Esto demuestra el uso combinado de `where`, `has` y `withCount`.

---

## Pregunta N:11 Usuario con más notas propias

```
>>> User::withCount(['notes as owned_notes_count' => fn($q) =>$q->where('note_user.role', 'owner')])->orderByDesc('owned_notes_count')->first(['name', 'email']);
= App\Models\User {
    name: "Admin",
    email: "admin@uatf.bo",
    owned_notes_count: 15,
}
```

**Respuesta / conclusión:**
Se identificó correctamente el usuario con mayor cantidad de notas propias utilizando un conteo condicionado sobre la tabla pivote.

---

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

**Respuesta / conclusión:**
Se eliminó correctamente un colaborador de la nota usando `detach()`. La disminución en el conteo confirma que la relación fue eliminada exitosamente.

---

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

**Respuesta / conclusión:**
La eliminación en cascada funcionó correctamente. Al eliminar una categoría, también se eliminaron sus notas y las relaciones en la tabla pivote, garantizando la integridad de los datos.
