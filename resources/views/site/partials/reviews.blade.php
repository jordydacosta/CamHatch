<ul class="review-list" id="review-list">
    @if(count($reviews) > 0)
        @foreach($reviews as $review)
            <li class="review-item" data-id="{{ $review->id }}">
                <ul class="rating-stars">
                    <li><span class="review-item-name uppercase">{{ $review->name }}</span></li>

                    <?php $total_stars = 5; ?>

                    @for ($i = 0; $i < $review->rating; $i++)
                        <li><img class="rating-normal" src="/img/rating.png" alt=""></li>
                        <?php $total_stars--; ?>
                    @endfor
                    {{-- calculate the empty stars --}}
                    @for ($i = 0; $i < $total_stars; $i++)
                        <li><img class="rating-off" src="/img/rating-off.png" alt=""></li>
                    @endfor
                </ul>
                <p class="review-item-description">
                    @if (App::getLocale() == 'nl')
                        {{ $review->description }}
                    @elseif(App::getLocale() == 'en')
                        {{ $review->description_en }}
                    @endif
                </p>
            </li>
        @endforeach
    @else
        <li class="review-item">
            <span class="review-item-name uppercase">@lang('general.no_reviews')</span>
        </li>
    @endif
</ul>