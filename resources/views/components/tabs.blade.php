{{-- Slot se renderuje prvi kako bi @push u x-tab djeci bio izvršen pre @stack poziva --}}
{{ $slot }}
<div class="tabs-component">
    <ul class="nav nav-tabs" id="nav-tab-{{ $tabs_id }}" role="tablist">
        @stack("tab_links_{$tabs_id}")
    </ul>
    <div class="tab-content mt-3" id="nav-tabContent-{{ $tabs_id }}">
        @stack("tab_content_{$tabs_id}")
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var hash = window.location.hash;
    if (hash) {
        var trigger = document.querySelector('[data-bs-toggle="tab"][href="' + hash + '"]');
        if (trigger) bootstrap.Tab.getOrCreateInstance(trigger).show();
    }
    document.querySelectorAll('[data-bs-toggle="tab"]').forEach(function (trigger) {
        trigger.addEventListener('shown.bs.tab', function (e) {
            history.replaceState(null, null, e.target.getAttribute('href'));
        });
    });
});
</script>