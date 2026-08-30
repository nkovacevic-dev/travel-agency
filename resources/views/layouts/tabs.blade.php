<div class="tabs-component">
    <ul class="nav nav-tabs" id="nav-tab-{{ $tabs_id }}" role="tablist">
        @stack("tab_links_{$tabs_id}")
    </ul>
    <div class="tab-content mt-3" id="nav-tabContent-{{ $tabs_id }}">
        @stack("tab_content_{$tabs_id}")
    </div>
</div>
