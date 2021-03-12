<p class="text-muted mx-4 my-auto">
  {{ $slot }}  {{ $date }}  {{ isset($name) ? ', by '.$name : null }}
</p>
