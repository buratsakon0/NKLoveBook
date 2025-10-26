@props(['paginator'])

<div class="flex justify-center gap-2">
  <!-- Previous Button -->
  @if ($paginator->onFirstPage())
    <span class="inline-flex items-center px-4 py-2 text-gray-300 bg-gray-200 rounded-full cursor-not-allowed">
      <i class="fa fa-arrow-left"></i>
    </span>
  @else
    <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="inline-flex items-center px-4 py-2 text-orange-500 bg-white border border-gray-300 rounded-full hover:bg-gray-200">
      <i class="fa fa-arrow-left"></i>
    </a>
  @endif

  <!-- Page Number Buttons -->
  @foreach ($elements as $element)
    @if (is_array($element))
      @foreach ($element as $page => $url)
        @if ($page == $paginator->currentPage())
          <span class="inline-flex items-center px-4 py-2 text-white bg-orange-600 border border-gray-300 rounded-full">
            {{ $page }}
          </span>
        @else
          <a href="{{ $url }}" class="inline-flex items-center px-4 py-2 text-orange-500 bg-white border border-gray-300 rounded-full hover:bg-gray-200">
            {{ $page }}
          </a>
        @endif
      @endforeach
    @endif
  @endforeach

  <!-- Next Button -->
  @if ($paginator->hasMorePages())
    <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="inline-flex items-center px-4 py-2 text-orange-500 bg-white border border-gray-300 rounded-full hover:bg-gray-200">
      <i class="fa fa-arrow-right"></i>
    </a>
  @else
    <span class="inline-flex items-center px-4 py-2 text-gray-300 bg-gray-200 rounded-full cursor-not-allowed">
      <i class="fa fa-arrow-right"></i>
    </span>
  @endif
</div>
