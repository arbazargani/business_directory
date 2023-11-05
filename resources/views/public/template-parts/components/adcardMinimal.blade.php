<div class="uk-padding-small">
    <div style="border: 1px solid #dddddd" class="uk-card uk-card-default uk-card-small uk-card-body uk-border-rounded">
        <p class="uk-card-title">
            <a href="{{ route('Public > Advertisement > Show', ['advertisement' => $ad->id, 'slug' => $ad->getSlug()]) }}" class="uk-link-reset">{{ $ad->title }}</a>
        </p>
        <span class="uk-text-meta">ساعت کاری: {{ json_decode($ad->work_hours, true)[0] }} - {{ json_decode($ad->work_hours, true)[1] }}</span>
    </div>
</div>
