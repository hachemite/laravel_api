<?php
// app/Http/Controllers/API/ArticleController.php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum'])->except(['index', 'show']);
    }
    public function index()
    {
        $articles = Article::with('user')->latest()->paginate(10);
        return ArticleResource::collection($articles);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $article = $request->user()->articles()->create($request->all());

        return new ArticleResource($article);
    }

    public function show($id)
    {
        $article = Article::with('user')->findOrFail($id);
        return new ArticleResource($article);
    }

    public function update(Request $request, $id)
    {
        $article = Article::findOrFail($id);

        // Vérifier si l'utilisateur est le propriétaire de l'article
        if ($request->user()->id !== $article->user_id) {
            return response()->json(['message' => 'Non autorisé'], 403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $article->update($request->all());

        return new ArticleResource($article);
    }

    public function destroy(Request $request, $id)
    {
        $article = Article::findOrFail($id);

        // Vérifier si l'utilisateur est le propriétaire de l'article
        if ($request->user()->id !== $article->user_id) {
            return response()->json(['message' => 'Non autorisé'], 403);
        }

        $article->delete();

        return response()->json(['message' => 'Article supprimé avec succès']);
    }

    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }
    }
}

Route::get('/login', function () {
    return response()->json(['message' => 'Please log in'], 401);
})->name('login');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::apiResource('articles', ArticleController::class);
});
