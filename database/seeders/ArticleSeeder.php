<?php
// database/seeders/ArticleSeeder.php
namespace Database\Seeders;

use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    public function run()
    {
        $users = User::all();

        foreach ($users as $user) {
            // Créer 3 articles pour chaque utilisateur
            for ($i = 1; $i <= 3; $i++) {
                Article::create([
                    'user_id' => $user->id,
                    'title' => "Article $i de " . $user->name,
                    'content' => "Contenu de l'article $i créé par " . $user->name,
                ]);
            }
        }
    }
}
