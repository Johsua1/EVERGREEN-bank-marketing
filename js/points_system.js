// Points System - Shared JavaScript Functions

class PointsSystem {
    constructor(apiUrl = '../points_api.php') {
        this.apiUrl = apiUrl;
        this.totalPoints = 0;
    }

    // Load user's total points
    async loadUserPoints() {
        try {
            const response = await fetch(`${this.apiUrl}?action=get_user_points`);
            const data = await response.json();
            
            if (data.success) {
                this.totalPoints = parseFloat(data.total_points);
                this.updatePointsDisplay();
                return this.totalPoints;
            }
        } catch (error) {
            console.error('Error loading points:', error);
        }
        return 0;
    }

    // Update points display on page
    updatePointsDisplay() {
        const pointsElements = document.querySelectorAll('#totalPoints, .points-number');
        pointsElements.forEach(el => {
            el.textContent = this.totalPoints.toFixed(2);
        });
    }

    // Load available missions
    async loadMissions() {
        try {
            const response = await fetch(`${this.apiUrl}?action=get_missions`);
            const data = await response.json();
            
            if (data.success) {
                return data.missions;
            }
        } catch (error) {
            console.error('Error loading missions:', error);
        }
        return [];
    }

    // Collect mission points
    async collectMission(missionId) {
        try {
            const formData = new FormData();
            formData.append('action', 'collect_mission');
            formData.append('mission_id', missionId);
            
            const response = await fetch(this.apiUrl, {
                method: 'POST',
                body: formData
            });
            
            const data = await response.json();
            
            if (data.success) {
                this.totalPoints = parseFloat(data.total_points);
                this.updatePointsDisplay();
                this.showSuccessMessage(data.points_earned);
                return data;
            } else {
                alert(data.message || 'Failed to collect mission');
                return null;
            }
        } catch (error) {
            console.error('Error collecting mission:', error);
            alert('An error occurred. Please try again.');
            return null;
        }
    }

    // Load point history
    async loadPointHistory() {
        try {
            const response = await fetch(`${this.apiUrl}?action=get_point_history`);
            const data = await response.json();
            
            if (data.success) {
                return data.history;
            }
        } catch (error) {
            console.error('Error loading history:', error);
        }
        return [];
    }

    // Load completed missions
    async loadCompletedMissions() {
        try {
            const response = await fetch(`${this.apiUrl}?action=get_completed_missions`);
            const data = await response.json();
            
            if (data.success) {
                return data.completed;
            }
        } catch (error) {
            console.error('Error loading completed missions:', error);
        }
        return [];
    }

    // Show success message
    showSuccessMessage(points) {
        const successMsg = document.createElement('div');
        successMsg.textContent = `+${points} points collected!`;
        successMsg.style.cssText = `
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: linear-gradient(135deg, #0d4d3d 0%, #1a6b56 100%);
            color: white;
            padding: 20px 40px;
            border-radius: 15px;
            font-size: 20px;
            font-weight: 700;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            z-index: 10000;
            animation: fadeInOut 2s ease;
        `;
        document.body.appendChild(successMsg);
        
        setTimeout(() => {
            successMsg.remove();
        }, 2000);
    }

    // Render missions in container
    async renderMissions(containerId) {
    const missions = await this.loadMissions();
    const container = document.getElementById(containerId);
    
    if (!container) return;
    
    container.innerHTML = '';
    
    if (missions.length === 0) {
        container.innerHTML = `
            <div class="empty-state">
                <div class="empty-state-icon">🎉</div>
                <div class="empty-state-text">All missions collected!</div>
            </div>
        `;
        return;
    }
    
    missions.forEach(mission => {
        const card = document.createElement('div');
        card.className = 'mission-card';
        
        const statusBadge = mission.status === 'pending' 
            ? '<span style="color:#ff9800;font-size:12px;font-weight:600;">⏳ Pending</span>'
            : '<span style="color:#4caf50;font-size:12px;font-weight:600;">✓ Available</span>';
        
        card.innerHTML = `
            <div class="mission-timestamp">${statusBadge}</div>
            <div class="mission-points">
                <div class="mission-points-value">${parseFloat(mission.points_value).toFixed(2)}</div>
                <div class="mission-points-label">points</div>
            </div>
            <div class="mission-divider"></div>
            <div class="mission-details">
                <div class="mission-description">${mission.mission_text}</div>
                <div class="mission-actions">
                    <button class="collect-btn" 
                            onclick="pointsSystem.collectMission(${mission.id}, this)"
                            ${mission.status === 'pending' ? 'disabled' : ''}>
                        ${mission.status === 'pending' ? 'Locked' : 'Collect'}
                    </button>
                </div>
            </div>
        `;
        
        container.appendChild(card);
    });
}

    // Create mission card element
    createMissionCard(mission) {
        const card = document.createElement('div');
        card.className = 'mission-card';
        card.dataset.missionId = mission.id;
        
        card.innerHTML = `
            <div class="mission-points">
                <div class="mission-points-value">${parseFloat(mission.points_value).toFixed(2)}</div>
                <div class="mission-points-label">points</div>
            </div>
            <div class="mission-divider"></div>
            <div class="mission-details">
                <div class="mission-description">${mission.mission_text}</div>
                <button class="collect-btn" onclick="handleCollectMission(${mission.id}, this)">Collect</button>
            </div>
        `;
        
        return card;
    }

    // Render point history
    async renderPointHistory(containerId) {
        const container = document.getElementById(containerId);
        if (!container) return;
        
        const history = await this.loadPointHistory();
        
        if (history.length === 0) {
            container.innerHTML = `
                <div class="empty-state">
                    <div class="empty-state-icon">📊</div>
                    <div class="empty-state-text">No point history yet</div>
                </div>
            `;
            return;
        }
        
        container.innerHTML = '';
        history.forEach(item => {
            const card = document.createElement('div');
            card.className = 'mission-card';
            card.innerHTML = `
                <div class="mission-timestamp">${item.timestamp}</div>
                <div class="mission-points">
                    <div class="mission-points-value">${item.points}</div>
                    <div class="mission-points-label">points</div>
                </div>
                <div class="mission-divider"></div>
                <div class="mission-details">
                    <div class="mission-description">${item.description}</div>
                    <div class="completed-badge">Completed</div>
                </div>
            `;
            container.appendChild(card);
        });
    }

    // Render completed missions
    async renderCompletedMissions(containerId) {
        const container = document.getElementById(containerId);
        if (!container) return;
        
        const completed = await this.loadCompletedMissions();
        
        if (completed.length === 0) {
            container.innerHTML = `
                <div class="empty-state">
                    <div class="empty-state-icon">✓</div>
                    <div class="empty-state-text">No completed missions yet</div>
                </div>
            `;
            return;
        }
        
        container.innerHTML = '';
        completed.forEach(item => {
            const card = document.createElement('div');
            card.className = 'mission-card';
            card.innerHTML = `
                <div class="mission-timestamp">${item.timestamp}</div>
                <div class="mission-points">
                    <div class="mission-points-value">${item.points}</div>
                    <div class="mission-points-label">points</div>
                </div>
                <div class="mission-divider"></div>
                <div class="mission-details">
                    <div class="mission-description">${item.description}</div>
                    <div class="completed-badge">Completed</div>
                </div>
            `;
            container.appendChild(card);
        });
    }
}

// Global instance
const pointsSystem = new PointsSystem('/points_api.php');

// Handle collect mission button click
async function handleCollectMission(missionId, button) {
    button.disabled = true;
    button.textContent = 'Collecting...';
    
    const result = await pointsSystem.collectMission(missionId);
    
    if (result) {
        // Remove the mission card with animation
        const missionCard = button.closest('.mission-card');
        missionCard.style.transition = 'all 0.5s ease';
        missionCard.style.opacity = '0';
        missionCard.style.transform = 'scale(0.9)';
        
        setTimeout(() => {
            missionCard.remove();
            
            // Check if mission container is empty
            const container = document.getElementById('mission');
            if (container && container.children.length === 0) {
                container.innerHTML = `
                    <div class="empty-state">
                        <div class="empty-state-icon">🎉</div>
                        <div class="empty-state-text">All missions completed!</div>
                    </div>
                `;
            }
            
            // Reload history and completed tabs
            pointsSystem.renderPointHistory('history');
            pointsSystem.renderCompletedMissions('completed');
        }, 500);
    } else {
        button.disabled = false;
        button.textContent = 'Collect';
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', async function() {
    // Load user's total points
    await pointsSystem.loadUserPoints();
    
    // Load missions if mission container exists
    const missionContainer = document.getElementById('mission');
    if (missionContainer) {
        await pointsSystem.renderMissions('mission');
    }
    
    // Add CSS for animations if not already present
    if (!document.getElementById('points-system-styles')) {
        const style = document.createElement('style');
        style.id = 'points-system-styles';
        style.textContent = `
            @keyframes fadeInOut {
                0% { opacity: 0; transform: translate(-50%, -50%) scale(0.8); }
                20% { opacity: 1; transform: translate(-50%, -50%) scale(1); }
                80% { opacity: 1; transform: translate(-50%, -50%) scale(1); }
                100% { opacity: 0; transform: translate(-50%, -50%) scale(0.8); }
            }
        `;
        document.head.appendChild(style);
    }
});