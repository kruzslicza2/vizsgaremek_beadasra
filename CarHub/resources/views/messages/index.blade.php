@extends('layout')
@section('content')
<div class="container py-4">
    <h2 class="mb-4 text-center fw-bold">Üzenetek</h2>

    <ul class="nav nav-tabs mb-4" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" data-bs-toggle="tab" href="#received">Beérkezett</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#sent">Elküldött</a>
        </li>
    </ul>

    <div class="tab-content">
        <!-- Beérkezett üzenetek -->
        <div class="tab-pane fade show active" id="received">
            @forelse($received as $message)
                <div class="card mb-3 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <strong>Feladó:</strong> {{ $message->sender->username }}
                                <br>
                                <strong>Hirdetés:</strong>
                                <a href="{{ route('cars.show', $message->car) }}">
                                    {{ $message->car->marka }} {{ $message->car->modell }}
                                </a>
                            </div>
                            <small class="text-muted">{{ $message->created_at->format('Y.m.d H:i') }}</small>
                        </div>

                        @if($message->reply_to)
                            <div class="alert alert-light mb-2">
                                <small class="text-muted">Eredeti üzenet:</small>
                                <br>
                                {{ $message->originalMessage->message }}
                            </div>
                        @endif

                        <p class="mb-3">{{ $message->message }}</p>

                        <!-- Válasz gomb és űrlap -->
                        <button class="btn btn-sm btn-primary"
                                onclick="showReplyForm('reply-{{ $message->id }}')">
                            <i class="fas fa-reply"></i> Válasz
                        </button>

                        <div id="reply-{{ $message->id }}" style="display:none;" class="mt-3">
                            <form action="{{ route('messages.store', $message->car) }}" method="POST">
                                @csrf
                                <input type="hidden" name="reply_to" value="{{ $message->id }}">
                                <div class="mb-3">
                                    <textarea name="message" class="form-control" rows="3"
                                              placeholder="Írd ide a válaszod..." required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary btn-sm">Küldés</button>
                                <button type="button" class="btn btn-secondary btn-sm"
                                        onclick="hideReplyForm('reply-{{ $message->id }}')">Mégse</button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="alert alert-info text-center">
                    Nincs beérkezett üzeneted.
                </div>
            @endforelse
        </div>

        <!-- Elküldött üzenetek -->
        <div class="tab-pane fade" id="sent">
            @forelse($sent as $message)
                <div class="card mb-3 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <strong>Címzett:</strong> {{ $message->receiver->username }}
                                <br>
                                <strong>Hirdetés:</strong>
                                <a href="{{ route('cars.show', $message->car) }}">
                                    {{ $message->car->marka }} {{ $message->car->modell }}
                                </a>
                            </div>
                            <small class="text-muted">{{ $message->created_at->format('Y.m.d H:i') }}</small>
                        </div>

                        @if($message->reply_to)
                            <div class="alert alert-light mb-2">
                                <small class="text-muted">Eredeti üzenet:</small>
                                <br>
                                {{ $message->originalMessage->message }}
                            </div>
                        @endif

                        <p>{{ $message->message }}</p>
                    </div>
                </div>
            @empty
                <div class="alert alert-info text-center">
                    Nincs elküldött üzeneted.
                </div>
            @endforelse
        </div>
    </div>
</div>

@push('scripts')
<script>
function showReplyForm(id) {
    const el = document.getElementById(id);
    if (el) el.style.display = 'block';
}

function hideReplyForm(id) {
    const el = document.getElementById(id);
    if (el) el.style.display = 'none';
}
</script>
@endpush
@endsection
