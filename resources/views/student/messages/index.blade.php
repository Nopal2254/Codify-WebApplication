@extends('layouts.app')

@section('title', __('Messages | Codify'))

@section('extra-css')
<style>
    /* Premium Glassmorphic Chat Layout */
    .chat-container {
        display: grid;
        grid-template-columns: 350px 1fr;
        height: 700px;
        background: rgba(255, 255, 255, 0.03);
        backdrop-filter: blur(24px) saturate(120%);
        -webkit-backdrop-filter: blur(24px) saturate(120%);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: var(--radius-lg);
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.35);
        overflow: hidden;
        margin-top: 20px;
    }

    /* Sidebar Conversations List */
    .chat-sidebar {
        border-right: 1px solid rgba(255, 255, 255, 0.08);
        display: flex;
        flex-direction: column;
        background: rgba(0, 0, 0, 0.15);
    }

    .chat-sidebar-header {
        padding: 24px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .chat-sidebar-title {
        font-size: 18px;
        font-weight: 700;
        color: #fff;
        margin: 0;
    }

    .btn-new-chat {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--brand), var(--accent, #6366f1));
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);
        transition: var(--transition);
    }

    .btn-new-chat:hover {
        transform: scale(1.05);
        box-shadow: 0 6px 20px rgba(99, 102, 241, 0.5);
    }

    .conversations-list {
        flex: 1;
        overflow-y: auto;
        padding: 12px;
    }

    .conversation-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 14px 16px;
        border-radius: var(--radius-md);
        margin-bottom: 8px;
        transition: var(--transition);
        cursor: pointer;
        color: inherit;
        text-decoration: none;
    }

    .conversation-item:hover {
        background: rgba(255, 255, 255, 0.04);
    }

    .conversation-item.active {
        background: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.12);
    }

    .avatar-box {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--brand), var(--accent, #6366f1));
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 15px;
        flex-shrink: 0;
    }

    .conversation-info {
        flex: 1;
        min-width: 0;
    }

    .conversation-header {
        display: flex;
        justify-content: space-between;
        align-items: baseline;
        margin-bottom: 4px;
    }

    .conversation-name {
        font-weight: 700;
        color: #fff;
        font-size: 14px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .conversation-time {
        font-size: 11px;
        color: var(--text-dim, #94a3b8);
    }

    .conversation-last-msg {
        font-size: 12px;
        color: var(--text-muted, #64748b);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .unread-badge {
        background: #ef4444;
        color: #fff;
        font-size: 10px;
        font-weight: 700;
        padding: 2px 6px;
        border-radius: var(--radius-full);
    }

    /* Active Chat Area */
    .chat-main {
        display: flex;
        flex-direction: column;
        background: rgba(0, 0, 0, 0.05);
    }

    .chat-header {
        padding: 20px 24px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        display: flex;
        align-items: center;
        gap: 14px;
        background: rgba(255, 255, 255, 0.01);
    }

    .chat-header-name {
        font-size: 16px;
        font-weight: 700;
        color: #fff;
    }

    .chat-header-status {
        font-size: 12px;
        color: #10b981;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .status-dot {
        width: 6px;
        height: 6px;
        background: #10b981;
        border-radius: 50%;
    }

    .chat-messages {
        flex: 1;
        overflow-y: auto;
        padding: 24px;
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .message-bubble {
        max-width: 65%;
        padding: 12px 16px;
        border-radius: var(--radius-md);
        font-size: 14px;
        line-height: 1.5;
        position: relative;
        word-break: break-word;
    }

    .message-bubble.incoming {
        align-self: flex-start;
        background: rgba(255, 255, 255, 0.06);
        border: 1px solid rgba(255, 255, 255, 0.08);
        color: #fff;
        border-top-left-radius: 2px;
    }

    .message-bubble.outgoing {
        align-self: flex-end;
        background: linear-gradient(135deg, var(--brand), var(--accent, #6366f1));
        color: #fff;
        border-top-right-radius: 2px;
    }

    .message-time {
        font-size: 10px;
        margin-top: 6px;
        text-align: right;
        opacity: 0.7;
    }

    .chat-input-area {
        padding: 20px 24px;
        border-top: 1px solid rgba(255, 255, 255, 0.08);
        display: flex;
        gap: 12px;
        background: rgba(0, 0, 0, 0.1);
    }

    .chat-input-field {
        flex: 1;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: var(--radius-md);
        padding: 12px 16px;
        color: #fff;
        font-size: 14px;
        outline: none;
        transition: var(--transition);
    }

    .chat-input-field:focus {
        border-color: var(--brand);
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
    }

    .chat-send-btn {
        width: 46px;
        height: 46px;
        border-radius: var(--radius-md);
        background: var(--brand);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        transition: var(--transition);
    }

    .chat-send-btn:hover {
        background: var(--brand-dark);
        transform: translateY(-1px);
    }

    .chat-placeholder {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: var(--text-dim, #94a3b8);
        padding: 40px;
        text-align: center;
        height: 100%;
    }

    .chat-placeholder i {
        font-size: 64px;
        color: rgba(255, 255, 255, 0.05);
        margin-bottom: 20px;
    }

    /* Modal Styling */
    .custom-modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.6);
        z-index: 2000;
        align-items: center;
        justify-content: center;
        backdrop-filter: blur(8px);
    }

    .custom-modal-content {
        background: #1e1e2e;
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: var(--radius-lg);
        width: 90%;
        max-width: 440px;
        padding: 24px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.4);
    }

    .custom-modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .custom-modal-header h5 {
        font-size: 18px;
        font-weight: 700;
        color: #fff;
        margin: 0;
    }

    .custom-modal-close {
        color: var(--text-dim, #94a3b8);
        font-size: 24px;
        cursor: pointer;
    }

    .custom-modal-body {
        margin-bottom: 20px;
    }

    .custom-modal-body label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: #fff;
        margin-bottom: 8px;
    }

    .form-control {
        width: 100%;
        padding: 10px 14px;
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: var(--radius-sm);
        background: rgba(0,0,0,0.2);
        color: #fff;
        outline: none;
    }

    /* Helper class to toggle visibility */
    .d-none {
        display: none !important;
    }

    /* Premium Scrollbars */
    .conversations-list::-webkit-scrollbar,
    .chat-messages::-webkit-scrollbar {
        width: 6px;
    }
    .conversations-list::-webkit-scrollbar-track,
    .chat-messages::-webkit-scrollbar-track {
        background: transparent;
    }
    .conversations-list::-webkit-scrollbar-thumb,
    .chat-messages::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.08);
        border-radius: 10px;
    }
    .conversations-list::-webkit-scrollbar-thumb:hover,
    .chat-messages::-webkit-scrollbar-thumb:hover {
        background: rgba(255, 255, 255, 0.16);
    }
</style>
@endsection

@section('content')
<div style="max-width: 1280px; margin: 0 auto; padding-top: 100px; padding-bottom: 60px;">
    @include('student.layouts.nav')

    <div class="chat-container">
        <!-- Sidebar -->
        <div class="chat-sidebar">
            <div class="chat-sidebar-header">
                <h3 class="chat-sidebar-title">{{ __('messages.dash.messages') }}</h3>
                <button class="btn-new-chat" onclick="openNewChatModal()" title="{{ __('New Conversation') }}">
                    <i class="fas fa-plus"></i>
                </button>
            </div>
            
            <div class="conversations-list">
                @forelse($conversations as $conv)
                    <a href="#" class="conversation-item" id="conv-{{ $conv->id }}" onclick="loadConversation(event, {{ $conv->id }})">
                        <div class="avatar-box">
                            {{ substr($conv->name, 0, 2) }}
                        </div>
                        <div class="conversation-info">
                            <div class="conversation-header">
                                <span class="conversation-name">{{ $conv->name }}</span>
                                <span class="conversation-time">
                                    {{ $conv->last_message ? $conv->last_message->created_at->diffForHumans() : '' }}
                                </span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="conversation-last-msg">
                                    {{ $conv->last_message ? $conv->last_message->body : __('No messages yet') }}
                                </span>
                                @if($conv->unread_count > 0)
                                    <span class="unread-badge" id="unread-badge-{{ $conv->id }}">{{ $conv->unread_count }}</span>
                                @endif
                            </div>
                        </div>
                    </a>
                @empty
                    <div style="text-align: center; color: var(--text-dim, #94a3b8); padding-top: 40px; font-size: 13px;">
                        {{ __('No conversations started yet.') }}
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Chat Pane -->
        <div class="chat-main">
            <!-- Placeholder -->
            <div class="chat-placeholder" id="chatPlaceholder">
                <i class="fas fa-comments"></i>
                <h4>{{ __('Select a Conversation') }}</h4>
                <p>{{ __('Choose a contact from the list or start a new conversation to start messaging.') }}</p>
            </div>

            <!-- Active Conversation -->
            <div class="d-none" id="activeChatBox" style="display: flex; flex-direction: column; height: 100%;">
                <div class="chat-header">
                    <div class="avatar-box" id="activeChatAvatar"></div>
                    <div>
                        <div class="chat-header-name" id="activeChatName"></div>
                        <div class="chat-header-status">
                            <span class="status-dot"></span> {{ __('Online') }}
                        </div>
                    </div>
                </div>

                <div class="chat-messages" id="chatMessages"></div>

                <div class="chat-input-area">
                    <input type="text" class="chat-input-field" id="messageInput" placeholder="{{ __('Write a message...') }}" autocomplete="off" onkeydown="handleEnterKey(event)">
                    <button class="chat-send-btn" onclick="sendMessage()">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- New Chat Modal -->
<div class="custom-modal-overlay" id="newChatModal">
    <div class="custom-modal-content">
        <div class="custom-modal-header">
            <h5>💬 {{ __('New Conversation') }}</h5>
            <span class="custom-modal-close" onclick="closeNewChatModal()">&times;</span>
        </div>
        <div class="custom-modal-body">
            <label for="newChatUser">{{ __('Select Recipient') }}</label>
            <select id="newChatUser" class="input-glass w-full">
                <option value="">-- {{ __('Select') }} --</option>
                @foreach($recipients as $u)
                    <option value="{{ $u->id }}">{{ $u->name }} ({{ __(ucfirst($u->role)) }})</option>
                @endforeach
            </select>
        </div>
        <div style="display: flex; justify-content: flex-end; gap: 12px;">
            <button class="btn btn-sm btn-ghost" onclick="closeNewChatModal()" style="color:#94a3b8;">{{ __('Cancel') }}</button>
            <button class="btn btn-sm btn-gradient" onclick="startNewChat()">{{ __('Start Chat') }}</button>
        </div>
    </div>
</div>
@endsection

@section('extra-js')
<script>
    let activeUserId = null;
    const currentUserId = {{ auth()->id() }};

    function openNewChatModal() {
        document.getElementById('newChatModal').style.display = 'flex';
    }

    function closeNewChatModal() {
        document.getElementById('newChatModal').style.display = 'none';
        document.getElementById('newChatUser').value = '';
    }

    function startNewChat() {
        const select = document.getElementById('newChatUser');
        const selectedId = select.value;
        if (!selectedId) return;

        closeNewChatModal();
        loadConversationDirectly(selectedId);
    }

    function loadConversation(event, userId) {
        event.preventDefault();
        loadConversationDirectly(userId);
    }

    function loadConversationDirectly(userId) {
        activeUserId = userId;

        // Highlight active item
        document.querySelectorAll('.conversation-item').forEach(item => {
            item.classList.remove('active');
        });
        const activeItem = document.getElementById('conv-' + userId);
        if (activeItem) {
            activeItem.classList.add('active');
        }

        // Hide placeholder and show active chat box
        document.getElementById('chatPlaceholder').classList.add('d-none');
        document.getElementById('activeChatBox').classList.remove('d-none');

        // Fetch messages via AJAX
        fetch(`/messages/${userId}`)
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    const contact = data.contact;
                    const messages = data.messages;

                    document.getElementById('activeChatName').innerText = contact.name;
                    document.getElementById('activeChatAvatar').innerText = contact.name.substring(0, 2);

                    const chatMessages = document.getElementById('chatMessages');
                    chatMessages.innerHTML = '';

                    messages.forEach(msg => {
                        appendMessageBubble(msg);
                    });

                    // Clear unread badge
                    const badge = document.getElementById('unread-badge-' + userId);
                    if (badge) badge.remove();

                    scrollToBottom();
                }
            });
    }

    function appendMessageBubble(msg) {
        const chatMessages = document.getElementById('chatMessages');
        const isOutgoing = msg.sender_id === currentUserId;

        const bubble = document.createElement('div');
        bubble.className = `message-bubble ${isOutgoing ? 'outgoing' : 'incoming'}`;
        
        // Date parsing helper
        const timeStr = new Date(msg.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

        bubble.innerHTML = `
            <div class="message-text">${escapeHtml(msg.body)}</div>
            <div class="message-time">${timeStr}</div>
        `;

        chatMessages.appendChild(bubble);
    }

    function sendMessage() {
        const input = document.getElementById('messageInput');
        const body = input.value.trim();
        if (!body || !activeUserId) return;

        input.value = '';

        const formData = new FormData();
        formData.append('receiver_id', activeUserId);
        formData.append('body', body);
        formData.append('_token', '{{ csrf_token() }}');

        fetch('/messages', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                appendMessageBubble(data.message);
                scrollToBottom();
            }
        });
    }

    function handleEnterKey(event) {
        if (event.key === 'Enter') {
            sendMessage();
        }
    }

    function scrollToBottom() {
        const chatMessages = document.getElementById('chatMessages');
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    function escapeHtml(text) {
        const map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return text.replace(/[&<>"']/g, function(m) { return map[m]; });
    }

    // Auto load conversation if user query parameter is provided
    document.addEventListener('DOMContentLoaded', () => {
        const urlParams = new URLSearchParams(window.location.search);
        const userParam = urlParams.get('user');
        if (userParam) {
            loadConversationDirectly(userParam);
        }
    });
</script>
@endsection