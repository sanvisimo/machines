@if(!empty($name))
    <div>
      <a href="/storage/{{ $name }}" target="_blank">
        <i class="fa-solid fa-file-image"></i> <span>{{ $name }}</span>
      </a>
  </div>
@else
  <div class="text-danger text-center">
    <svg
      xmlns="http://www.w3.org/2000/svg"
      class="fill-current"
      width="24"
      height="24"
      viewBox="0 0 24 24"
      role="presentation"
    >
      <path
        d="M4.93 19.07A10 10 0 1 1 19.07 4.93 10 10 0 0 1 4.93 19.07zm1.41-1.41A8 8 0 1 0 17.66 6.34 8 8 0 0 0 6.34 17.66zM13.41 12l1.42 1.41a1 1 0 1 1-1.42 1.42L12 13.4l-1.41 1.42a1 1 0 1 1-1.42-1.42L10.6 12l-1.42-1.41a1 1 0 1 1 1.42-1.42L12 10.6l1.41-1.42a1 1 0 1 1 1.42 1.42L13.4 12z"
      />
    </svg>
  </div>
@endif
