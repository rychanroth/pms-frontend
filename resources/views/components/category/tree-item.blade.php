@props(['node', 'depth' => 0])

<option value="{{ $node['id'] }}">
    {{ str_repeat('--', $depth) }} {{ $node['name'] }}
</option>

@if(!empty($node['children']))
    @foreach($node['children'] as $child)
        <x-category.tree-item :node="$child" :depth="$depth + 1" />
    @endforeach
@endif