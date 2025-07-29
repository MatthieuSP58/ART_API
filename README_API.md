# API Articles - Documentation

## 📋 Vue d'ensemble

Cette API REST permet de gérer des articles avec les opérations CRUD complètes (Create, Read, Update, Delete). Elle est développée avec Laravel 12 et utilise une base de données SQLite.

## 🚀 Technologies utilisées

- **Framework** : Laravel 12
- **PHP** : 8.2+
- **Base de données** : SQLite
- **Authentification** : Laravel Sanctum
- **Format de réponse** : JSON

## 📊 Structure des données

### Modèle Article

```json
{
  "id": 1,
  "title": "Titre de l'article",
  "content": "Contenu de l'article...",
  "published": true,
  "created_at": "2025-07-29T10:30:00.000000Z",
  "updated_at": "2025-07-29T10:30:00.000000Z"
}
```

### Champs obligatoires
- `title` : Chaîne de caractères (max 225 caractères)
- `content` : Texte (obligatoire)
- `published` : Booléen (optionnel, défaut : false)

## 🛣️ Endpoints de l'API

### Base URL
```
http://localhost:8000/api
```

## 📖 Documentation des endpoints

### 1. Récupérer tous les articles

**GET** `/api/article`

#### Exemple avec JavaScript (Fetch API)
```javascript
async function getAllArticles() {
    try {
        const response = await fetch('http://localhost:8000/api/article', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        });
        
        const data = await response.json();
        
        if (data.success) {
            console.log('Articles récupérés:', data.articles);
            return data.articles;
        }
    } catch (error) {
        console.error('Erreur:', error);
    }
}

// Utilisation
getAllArticles().then(articles => {
    articles.forEach(article => {
        console.log(`${article.title} - Publié: ${article.published}`);
    });
});
```

#### Exemple avec Axios
```javascript
import axios from 'axios';

const apiClient = axios.create({
    baseURL: 'http://localhost:8000/api',
    headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json'
    }
});

async function getAllArticles() {
    try {
        const response = await apiClient.get('/article');
        return response.data.articles;
    } catch (error) {
        console.error('Erreur lors de la récupération:', error.response.data);
    }
}
```

### 2. Récupérer un article spécifique

**GET** `/api/article/{id}`

#### Exemple JavaScript
```javascript
async function getArticleById(articleId) {
    try {
        const response = await fetch(`http://localhost:8000/api/article/${articleId}`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        });
        
        const data = await response.json();
        
        if (data.success) {
            console.log('Article trouvé:', data.article);
            return data.article;
        }
    } catch (error) {
        console.error('Erreur:', error);
    }
}

// Utilisation
getArticleById(1).then(article => {
    if (article) {
        console.log(`Titre: ${article.title}`);
        console.log(`Contenu: ${article.content}`);
        console.log(`Publié: ${article.published ? 'Oui' : 'Non'}`);
    }
});
```

### 3. Créer un nouvel article

**POST** `/api/article`

#### Exemple JavaScript
```javascript
async function createArticle(articleData) {
    try {
        const response = await fetch('http://localhost:8000/api/article', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify(articleData)
        });
        
        const data = await response.json();
        
        if (response.ok && data.success) {
            console.log('Article créé avec succès:', data.article);
            return data.article;
        } else {
            console.error('Erreur de validation:', data);
        }
    } catch (error) {
        console.error('Erreur:', error);
    }
}

// Utilisation
const nouvelArticle = {
    title: "Mon premier article",
    content: "Ceci est le contenu de mon premier article via l'API.",
    published: true
};

createArticle(nouvelArticle).then(article => {
    if (article) {
        console.log(`Article créé avec l'ID: ${article.id}`);
    }
});
```

#### Exemple avec validation côté client
```javascript
function validateArticleData(data) {
    const errors = [];
    
    if (!data.title || data.title.trim() === '') {
        errors.push('Le titre est obligatoire');
    }
    
    if (data.title && data.title.length > 225) {
        errors.push('Le titre ne peut pas dépasser 225 caractères');
    }
    
    if (!data.content || data.content.trim() === '') {
        errors.push('Le contenu est obligatoire');
    }
    
    return errors;
}

async function createArticleWithValidation(articleData) {
    // Validation côté client
    const errors = validateArticleData(articleData);
    if (errors.length > 0) {
        console.error('Erreurs de validation:', errors);
        return null;
    }
    
    return await createArticle(articleData);
}
```### 4. Modifier un article existant

**PUT** `/api/article/{id}`

#### Exemple JavaScript
```javascript
async function updateArticle(articleId, updatedData) {
    try {
        const response = await fetch(`http://localhost:8000/api/article/${articleId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify(updatedData)
        });
        
        const data = await response.json();
        
        if (response.ok && data.success) {
            console.log('Article modifié avec succès:', data.article);
            return data.article;
        } else {
            console.error('Erreur lors de la modification:', data);
        }
    } catch (error) {
        console.error('Erreur:', error);
    }
}

// Utilisation
const donneesModifiees = {
    title: "Titre modifié",
    content: "Contenu mis à jour avec de nouvelles informations.",
    published: false
};

updateArticle(1, donneesModifiees).then(article => {
    if (article) {
        console.log('Modification réussie:', article.title);
    }
});
```

#### Exemple de modification partielle
```javascript
async function togglePublishStatus(articleId) {
    // Récupérer l'article actuel
    const article = await getArticleById(articleId);
    
    if (article) {
        // Inverser le statut de publication
        const updatedData = {
            title: article.title,
            content: article.content,
            published: !article.published
        };
        
        return await updateArticle(articleId, updatedData);
    }
}

// Utilisation
togglePublishStatus(1).then(article => {
    console.log(`Statut de publication changé: ${article.published}`);
});
```

### 5. Supprimer un article

**DELETE** `/api/article/{id}`

#### Exemple JavaScript
```javascript
async function deleteArticle(articleId) {
    try {
        const response = await fetch(`http://localhost:8000/api/article/${articleId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        });
        
        const data = await response.json();
        
        if (response.ok && data.success) {
            console.log('Article supprimé avec succès');
            return true;
        } else {
            console.error('Erreur lors de la suppression:', data);
            return false;
        }
    } catch (error) {
        console.error('Erreur:', error);
        return false;
    }
}

// Utilisation avec confirmation
async function deleteArticleWithConfirmation(articleId) {
    const article = await getArticleById(articleId);
    
    if (article && confirm(`Êtes-vous sûr de vouloir supprimer "${article.title}" ?`)) {
        const success = await deleteArticle(articleId);
        
        if (success) {
            console.log('Article supprimé définitivement');
        }
    }
}
```

## 🔧 Classe utilitaire pour l'API

Voici une classe JavaScript complète pour interagir avec l'API :

```javascript
class ArticleAPI {
    constructor(baseURL = 'http://localhost:8000/api') {
        this.baseURL = baseURL;
        this.headers = {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        };
    }
    
    async request(endpoint, options = {}) {
        try {
            const response = await fetch(`${this.baseURL}${endpoint}`, {
                headers: this.headers,
                ...options
            });
            
            const data = await response.json();
            
            if (!response.ok) {
                throw new Error(data.message || 'Erreur de requête');
            }
            
            return data;
        } catch (error) {
            console.error('Erreur API:', error);
            throw error;
        }
    }
    
    // Récupérer tous les articles
    async getAll() {
        const data = await this.request('/article');
        return data.articles;
    }
    
    // Récupérer un article par ID
    async getById(id) {
        const data = await this.request(`/article/${id}`);
        return data.article;
    }
    
    // Créer un nouvel article
    async create(articleData) {
        const data = await this.request('/article', {
            method: 'POST',
            body: JSON.stringify(articleData)
        });
        return data.article;
    }
    
    // Modifier un article
    async update(id, articleData) {
        const data = await this.request(`/article/${id}`, {
            method: 'PUT',
            body: JSON.stringify(articleData)
        });
        return data.article;
    }
    
    // Supprimer un article
    async delete(id) {
        await this.request(`/article/${id}`, {
            method: 'DELETE'
        });
        return true;
    }
    
    // Méthodes utilitaires
    async getPublishedArticles() {
        const articles = await this.getAll();
        return articles.filter(article => article.published);
    }
    
    async getDraftArticles() {
        const articles = await this.getAll();
        return articles.filter(article => !article.published);
    }
}

// Utilisation de la classe
const api = new ArticleAPI();

// Exemples d'utilisation
async function exempleUtilisation() {
    try {
        // Créer un article
        const nouvelArticle = await api.create({
            title: "Article via classe API",
            content: "Contenu créé avec la classe utilitaire",
            published: true
        });
        
        console.log('Article créé:', nouvelArticle);
        
        // Récupérer tous les articles publiés
        const articlesPublies = await api.getPublishedArticles();
        console.log('Articles publiés:', articlesPublies);
        
        // Modifier l'article
        const articleModifie = await api.update(nouvelArticle.id, {
            title: "Titre modifié",
            content: nouvelArticle.content,
            published: false
        });
        
        console.log('Article modifié:', articleModifie);
        
    } catch (error) {
        console.error('Erreur:', error);
    }
}
```

## 📱 Exemple d'intégration avec une interface web

### HTML simple avec JavaScript
```html
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionnaire d'Articles</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .article { border: 1px solid #ddd; margin: 10px 0; padding: 15px; }
        .published { background-color: #e8f5e8; }
        .draft { background-color: #fff3e0; }
        button { margin: 5px; padding: 8px 16px; cursor: pointer; }
    </style>
</head>
<body>
    <h1>Gestionnaire d'Articles</h1>
    
    <div id="formulaire">
        <h2>Créer un article</h2>
        <input type="text" id="title" placeholder="Titre de l'article" />
        <textarea id="content" placeholder="Contenu de l'article"></textarea>
        <label>
            <input type="checkbox" id="published" /> Publié
        </label>
        <button onclick="creerArticle()">Créer l'article</button>
    </div>
    
    <div id="articles"></div>
    
    <script>
        const api = new ArticleAPI();
        
        async function chargerArticles() {
            try {
                const articles = await api.getAll();
                const container = document.getElementById('articles');
                
                container.innerHTML = articles.map(article => `
                    <div class="article ${article.published ? 'published' : 'draft'}">
                        <h3>${article.title}</h3>
                        <p>${article.content}</p>
                        <p><strong>Statut:</strong> ${article.published ? 'Publié' : 'Brouillon'}</p>
                        <p><strong>Créé le:</strong> ${new Date(article.created_at).toLocaleDateString()}</p>
                        <button onclick="modifierArticle(${article.id})">Modifier</button>
                        <button onclick="supprimerArticle(${article.id})">Supprimer</button>
                    </div>
                `).join('');
                
            } catch (error) {
                console.error('Erreur lors du chargement:', error);
            }
        }
        
        async function creerArticle() {
            const title = document.getElementById('title').value;
            const content = document.getElementById('content').value;
            const published = document.getElementById('published').checked;
            
            if (!title || !content) {
                alert('Veuillez remplir tous les champs obligatoires');
                return;
            }
            
            try {
                await api.create({ title, content, published });
                
                // Réinitialiser le formulaire
                document.getElementById('title').value = '';
                document.getElementById('content').value = '';
                document.getElementById('published').checked = false;
                
                // Recharger la liste
                chargerArticles();
                
            } catch (error) {
                alert('Erreur lors de la création: ' + error.message);
            }
        }
        
        async function supprimerArticle(id) {
            if (confirm('Êtes-vous sûr de vouloir supprimer cet article ?')) {
                try {
                    await api.delete(id);
                    chargerArticles();
                } catch (error) {
                    alert('Erreur lors de la suppression: ' + error.message);
                }
            }
        }
        
        // Charger les articles au démarrage
        chargerArticles();
    </script>
</body>
</html>
```## 🔐 Authentification (Laravel Sanctum)

Si vous activez l'authentification Sanctum, voici comment modifier vos requêtes :

### Connexion et récupération du token
```javascript
async function login(email, password) {
    try {
        const response = await fetch('http://localhost:8000/api/login', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ email, password })
        });
        
        const data = await response.json();
        
        if (data.token) {
            // Stocker le token
            localStorage.setItem('api_token', data.token);
            return data.token;
        }
    } catch (error) {
        console.error('Erreur de connexion:', error);
    }
}
```

### Classe API avec authentification
```javascript
class AuthenticatedArticleAPI extends ArticleAPI {
    constructor(baseURL = 'http://localhost:8000/api') {
        super(baseURL);
        this.token = localStorage.getItem('api_token');
        
        if (this.token) {
            this.headers['Authorization'] = `Bearer ${this.token}`;
        }
    }
    
    setToken(token) {
        this.token = token;
        this.headers['Authorization'] = `Bearer ${token}`;
        localStorage.setItem('api_token', token);
    }
    
    removeToken() {
        this.token = null;
        delete this.headers['Authorization'];
        localStorage.removeItem('api_token');
    }
}
```

## ⚠️ Gestion des erreurs

### Codes de réponse HTTP
- `200` : Succès (GET, PUT, DELETE)
- `201` : Ressource créée (POST)
- `400` : Erreur de validation
- `404` : Article non trouvé
- `422` : Erreur de validation des données
- `500` : Erreur serveur

### Exemple de gestion d'erreurs avancée
```javascript
class APIError extends Error {
    constructor(message, status, details = null) {
        super(message);
        this.status = status;
        this.details = details;
        this.name = 'APIError';
    }
}

async function requestWithErrorHandling(url, options = {}) {
    try {
        const response = await fetch(url, options);
        const data = await response.json();
        
        if (!response.ok) {
            switch (response.status) {
                case 400:
                    throw new APIError('Données invalides', 400, data.errors);
                case 404:
                    throw new APIError('Article non trouvé', 404);
                case 422:
                    throw new APIError('Erreur de validation', 422, data.errors);
                case 500:
                    throw new APIError('Erreur serveur', 500);
                default:
                    throw new APIError('Erreur inconnue', response.status);
            }
        }
        
        return data;
    } catch (error) {
        if (error instanceof APIError) {
            throw error;
        }
        throw new APIError('Erreur de réseau', 0, error.message);
    }
}
```

## 🧪 Tests côté client

### Tests unitaires avec Jest
```javascript
// articleAPI.test.js
import { ArticleAPI } from './articleAPI.js';

// Mock fetch
global.fetch = jest.fn();

describe('ArticleAPI', () => {
    let api;
    
    beforeEach(() => {
        api = new ArticleAPI();
        fetch.mockClear();
    });
    
    test('getAll devrait retourner tous les articles', async () => {
        const mockArticles = [
            { id: 1, title: 'Test', content: 'Contenu', published: true }
        ];
        
        fetch.mockResolvedValueOnce({
            ok: true,
            json: async () => ({ success: true, articles: mockArticles })
        });
        
        const articles = await api.getAll();
        
        expect(articles).toEqual(mockArticles);
        expect(fetch).toHaveBeenCalledWith(
            'http://localhost:8000/api/article',
            expect.objectContaining({
                headers: expect.objectContaining({
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                })
            })
        );
    });
});
```

## 📋 Exemples de cas d'usage

### 1. Dashboard d'administration
```javascript
class ArticleDashboard {
    constructor() {
        this.api = new ArticleAPI();
        this.stats = {};
    }
    
    async loadDashboard() {
        const articles = await this.api.getAll();
        
        this.stats = {
            total: articles.length,
            published: articles.filter(a => a.published).length,
            drafts: articles.filter(a => !a.published).length,
            recent: articles
                .sort((a, b) => new Date(b.created_at) - new Date(a.created_at))
                .slice(0, 5)
        };
        
        this.renderStats();
    }
    
    renderStats() {
        console.log('📊 Statistiques des articles:');
        console.log(`Total: ${this.stats.total}`);
        console.log(`Publiés: ${this.stats.published}`);
        console.log(`Brouillons: ${this.stats.drafts}`);
        console.log('Articles récents:', this.stats.recent.map(a => a.title));
    }
}
```

### 2. Système de recherche
```javascript
class ArticleSearch {
    constructor() {
        this.api = new ArticleAPI();
        this.articles = [];
    }
    
    async loadArticles() {
        this.articles = await this.api.getAll();
    }
    
    search(query, options = {}) {
        const { publishedOnly = false, sortBy = 'created_at' } = options;
        
        let results = this.articles.filter(article => {
            const searchText = `${article.title} ${article.content}`.toLowerCase();
            const matchesQuery = searchText.includes(query.toLowerCase());
            const matchesPublished = !publishedOnly || article.published;
            
            return matchesQuery && matchesPublished;
        });
        
        // Tri
        results.sort((a, b) => {
            if (sortBy === 'title') return a.title.localeCompare(b.title);
            if (sortBy === 'created_at') return new Date(b.created_at) - new Date(a.created_at);
            return 0;
        });
        
        return results;
    }
}

// Utilisation
const search = new ArticleSearch();
await search.loadArticles();

const results = search.search('Laravel', { 
    publishedOnly: true, 
    sortBy: 'title' 
});
```

## 🚀 Installation et démarrage

### Prérequis
- PHP 8.2+
- Composer
- Node.js (pour les assets frontend)

### Installation
```bash
# Cloner le projet
git clone <votre-repo>
cd ART_API

# Installer les dépendances PHP
composer install

# Configurer l'environnement
cp .env.example .env
php artisan key:generate

# Créer la base de données et exécuter les migrations
touch database/database.sqlite
php artisan migrate

# Démarrer le serveur de développement
php artisan serve
```

### Test de l'API
```bash
# Tester avec curl
curl -X GET http://localhost:8000/api/article \
     -H "Accept: application/json"

# Créer un article de test
curl -X POST http://localhost:8000/api/article \
     -H "Content-Type: application/json" \
     -H "Accept: application/json" \
     -d '{"title":"Test Article","content":"Contenu de test","published":true}'
```

## 📈 Améliorations futures

### Fonctionnalités suggérées
1. **Pagination** : Ajouter la pagination pour les listes d'articles
2. **Filtres avancés** : Par date, auteur, catégorie
3. **Upload d'images** : Support des médias
4. **Versioning** : Historique des modifications
5. **Cache** : Mise en cache des réponses API
6. **Rate limiting** : Limitation du taux de requêtes

### Exemple d'implémentation de pagination
```javascript
// Côté API Laravel (à ajouter dans ArticleController)
public function index(Request $request)
{
    $perPage = $request->get('per_page', 10);
    $articles = Article::paginate($perPage);
    
    return response()->json([
        'success' => true,
        'articles' => $articles->items(),
        'pagination' => [
            'current_page' => $articles->currentPage(),
            'last_page' => $articles->lastPage(),
            'per_page' => $articles->perPage(),
            'total' => $articles->total()
        ]
    ]);
}

// Côté JavaScript
async function getArticlesWithPagination(page = 1, perPage = 10) {
    const response = await fetch(`/api/article?page=${page}&per_page=${perPage}`);
    const data = await response.json();
    
    return {
        articles: data.articles,
        pagination: data.pagination
    };
}
```

---

## 📞 Support

Pour toute question ou problème :
1. Vérifiez que le serveur Laravel est en cours d'exécution
2. Contrôlez les logs Laravel : `php artisan log:tail`
3. Utilisez les outils de développement du navigateur pour déboguer les requêtes

**Auteur** : [Votre nom]  
**Version** : 1.0  
**Dernière mise à jour** : Juillet 2025