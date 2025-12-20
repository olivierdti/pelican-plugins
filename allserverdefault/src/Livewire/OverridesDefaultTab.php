<?php

namespace AllServerDefault\Livewire;

use Livewire\Component;


trait OverridesDefaultTab
{   

    public function mountOverridesDefaultTab(): void
    {
        if (!isset($this->activeTab) || $this->activeTab === 'my') {
            $this->activeTab = 'all';
        }
    }


    public function hydrateOverridesDefaultTab(): void
    {
        if (session('first_visit_servers', true)) {
            $this->activeTab = 'all';
            session(['first_visit_servers' => false]);
        }
    }
}
