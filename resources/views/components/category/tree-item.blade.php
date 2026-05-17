@props(['node'])

<option value="{{ $node['id'] }}">
    {{ str_repeat('--', $node['depth']) }} {{ $node['name'] }}
</option>

@if(!empty($node['children']))
    @foreach($node['children'] as $child)
        <x-category.tree-item :node="$child" />
    @endforeach
@endif