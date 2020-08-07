<ul class="border-bottom">
        <li><a href="{{route('category.products', ['category' => $children->id])}}">{{ $children->getTranslatedAttribute('name')}}</a></li>
</ul>
