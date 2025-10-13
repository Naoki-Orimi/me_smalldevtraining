import './bootstrap';

// 基本的なJavaScript機能
document.addEventListener('DOMContentLoaded', function() {
    // モバイルメニューのトグル（将来実装）
    initMobileMenu();
    
    // 通知の表示（将来実装）
    initNotifications();
    
    // その他の初期化処理
    initApp();
});

/**
 * モバイルメニューの初期化
 */
function initMobileMenu() {
    // 将来実装予定
    console.log('Mobile menu initialized');
}

/**
 * 通知機能の初期化
 */
function initNotifications() {
    // 将来実装予定
    console.log('Notifications initialized');
}

/**
 * アプリケーション全体の初期化
 */
function initApp() {
    // CSRFトークンをAxiosに設定
    const token = document.querySelector('meta[name="csrf-token"]');
    if (token) {
        window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.getAttribute('content');
    }
    
    console.log('GPTer System initialized');
}

/**
 * ユーティリティ関数
 */
window.GPTer = {
    // 日付フォーマット
    formatDate: function(date) {
        return new Date(date).toLocaleDateString('ja-JP');
    },
    
    // ステータスバッジのクラス取得
    getStatusClass: function(status) {
        const statusMap = {
            'not-started': 'status-not-started',
            'in-progress': 'status-in-progress',
            'on-hold': 'status-on-hold',
            'completed': 'status-completed'
        };
        return statusMap[status] || 'status-not-started';
    },
    
    // 優先度のクラス取得
    getPriorityClass: function(priority) {
        const priorityMap = {
            'low': 'priority-low',
            'medium': 'priority-medium',
            'high': 'priority-high'
        };
        return priorityMap[priority] || 'priority-low';
    }
};
