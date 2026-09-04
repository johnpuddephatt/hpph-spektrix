<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Local copies of the Spektrix ticket subscription structures (flex passes),
     * with the marketing content editors layer on top.
     *
     * Unlike every other imported model, the id is NOT a Spektrix id:
     * GET /ticket-subscription-structures returns no identifier on the structure
     * itself, only on its nested pricing sets. The id here is a slug of the
     * structure name, which is the only stable handle Spektrix gives us. Renaming
     * a subscription in Spektrix therefore reads as a new row, and the old one is
     * disabled with its content intact for an editor to re-point at.
     *
     * The pricing sets are stored whole because their ids are what gets posted to
     * the basket, and a structure may carry several (Standard, Concession...).
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket_subscriptions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->timestamps();
            $table->softDeletes();
            $table->boolean('enabled')->default(false);

            // Imported from Spektrix.
            $table->string('name');
            $table->text('spektrix_description')->nullable();
            $table->json('pricing_sets')->nullable();
            $table->timestamp('on_sale_at')->nullable();
            $table->timestamp('off_sale_at')->nullable();

            // Added by editors in Nova.

            // The strand or season this pass is sold alongside, which is what
            // puts it on that page. Polymorphic rather than a strand_id/season_id
            // pair so there is exactly one thing for an editor to set, and no way
            // to half-fill both. One pass per strand or season by convention —
            // the templates read a morphOne, so a second would simply not show.
            $table->nullableMorphs('subject');

            $table->text('description')->nullable();
            $table->json('benefits')->nullable();
            $table->text('terms')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ticket_subscriptions');
    }
};
