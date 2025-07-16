@props(['items'=>$items])
			<div class="row">
				<div class="col-lg-12 text-center">
					<div class="pagination-wrap">
						<ul>
							{{-- Prev Page --}}
							@if ($items->onFirstPage())
								<li><span style="color: #ccc;">Prev</span></li>
							@else
								<li><a href="{{ $items->previousPageUrl() }}">Prev</a></li>
							@endif

							{{-- Page Links --}}
							@for ($i = 1; $i <= $items->lastPage(); $i++)
								<li>
									<a href="{{ $items->url($i) }}" class="{{ $items->currentPage() == $i ? 'active' : '' }}">
										{{ $i }}
									</a>
								</li>
							@endfor

							{{-- Next Page --}}
							@if ($items->hasMorePages())
								<li><a href="{{ $items->nextPageUrl() }}">Next</a></li>
							@else
								<li><span style="color: #ccc;">Next</span></li>
							@endif
						</ul>
					</div>

				</div>
			</div>
