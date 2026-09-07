<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Opportunity;
use App\Models\Page;
use App\Models\Post;
use App\Models\Product;
use App\Models\Season;
use App\Models\Strand;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

/**
 * Builds /sitemap.xml from the CMS rather than by crawling.
 *
 * Crawling is a poor fit here: the programme listings are Livewire-driven, so a
 * crawler sees only the first page of results, and the site links out to Spektrix
 * booking pages that must not end up in the sitemap.
 *
 * No file is written and nothing is scheduled. The response cache already covers
 * this route (all successful GETs are cached for an hour), and ModelObserver
 * flushes that cache whenever watched content changes — so the sitemap is rebuilt
 * on the first request after an edit or a Spektrix import, and served from cache
 * the rest of the time.
 */
class SitemapController extends Controller
{
    /**
     * Page templates that exist to serve a transaction or an error, and so have
     * nothing to offer a search engine.
     */
    protected const EXCLUDED_TEMPLATES = [
        '404-page',
        'account-page',
        'basket-page',
        'checkout-page',
        'gift-membership-postage-page',
    ];

    public function __invoke()
    {
        $sitemap = Sitemap::create();

        foreach ($this->urls() as $url) {
            $sitemap->add($url);
        }

        return $sitemap;
    }

    /**
     * Every public URL, keyed by URL so a model that resolves to a path already
     * covered by a CMS page cannot be listed twice.
     */
    protected function urls(): Collection
    {
        return collect()
            ->merge($this->pages())
            ->merge($this->events())
            ->merge($this->strands())
            ->merge($this->seasons())
            ->merge($this->posts())
            ->merge($this->products())
            ->merge($this->opportunities())
            ->merge($this->team())
            ->keyBy(fn (Url $url) => $url->url);
    }

    protected function pages(): Collection
    {
        return Page::whereNotIn('template', self::EXCLUDED_TEMPLATES)
            ->get()
            // Page::url is built by walking up the parent chain, so it is a path
            // rather than an absolute URL, and it is not resolvable in SQL.
            ->map(fn (Page $page) => $this->url(
                url($page->url),
                $page,
                $page->url === '/' ? 1.0 : 0.8,
            ));
    }

    /**
     * Past screenings are kept: the pages stay live and carry the write-ups and
     * images that make them worth finding.
     */
    protected function events(): Collection
    {
        return Event::shownInProgramme()
            ->select('slug')
            ->get()
            ->map(fn (Event $event) => $this->url($event->url, $event, 0.7));
    }

    protected function strands(): Collection
    {
        return Strand::showInProgramme()
            ->select('id', 'slug')
            ->get()
            ->map(fn (Strand $strand) => $this->url($strand->url, $strand, 0.6));
    }

    protected function seasons(): Collection
    {
        return Season::showInProgramme()
            ->select('id', 'slug')
            ->get()
            ->map(fn (Season $season) => $this->url($season->url, $season, 0.6));
    }

    protected function posts(): Collection
    {
        return Post::all()
            ->map(fn (Post $post) => $this->url($post->url, $post, 0.6));
    }

    protected function products(): Collection
    {
        return Product::all()
            ->map(fn (Product $product) => $this->url($product->url, $product, 0.5));
    }

    protected function opportunities(): Collection
    {
        return Opportunity::all()
            ->map(fn (Opportunity $opportunity) => $this->url($opportunity->url, $opportunity, 0.5));
    }

    /**
     * Mirrors UserController, which 404s anyone not in the directory — most User
     * rows are Nova logins with no public page.
     */
    protected function team(): Collection
    {
        return User::where('show_in_directory', true)
            ->get()
            ->map(fn (User $user) => $this->url($user->url, $user, 0.4));
    }

    /**
     * The Spektrix-imported models have $timestamps = false, so lastmod is only
     * set for the models that can actually answer the question.
     */
    protected function url(string $location, Model $model, float $priority): Url
    {
        $url = Url::create($location)->setPriority($priority);

        if ($model->usesTimestamps() && $model->updated_at) {
            $url->setLastModificationDate($model->updated_at);
        }

        return $url;
    }
}
