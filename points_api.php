<?php
session_start();
include("db_connect.php");

header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit;
}

$user_id = $_SESSION['user_id'];
$action = $_POST['action'] ?? $_GET['action'] ?? '';

switch ($action) {
    case 'get_user_points':
        getUserPoints($conn, $user_id);
        break;
    
    case 'get_missions':
        getMissions($conn, $user_id);
        break;
    
    case 'collect_mission':
        collectMission($conn, $user_id);
        break;
    
    case 'get_point_history':
        getPointHistory($conn, $user_id);
        break;
    
    case 'get_completed_missions':
        getCompletedMissions($conn, $user_id);
        break;
    
    default:
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
}

function getUserPoints($conn, $user_id) {
    $sql = "SELECT total_points FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
        echo json_encode([
            'success' => true,
            'total_points' => number_format($row['total_points'], 2, '.', '')
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'User not found']);
    }
    $stmt->close();
}

function getMissions($conn, $user_id) {
    // Get all missions that user hasn't completed yet
    $sql = "SELECT m.id, m.mission_text, m.points_value 
            FROM missions m
            LEFT JOIN user_missions um ON m.id = um.mission_id AND um.user_id = ?
            WHERE um.id IS NULL
            ORDER BY m.id";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $missions = [];
    while ($row = $result->fetch_assoc()) {
        $missions[] = $row;
    }
    
    echo json_encode([
        'success' => true,
        'missions' => $missions
    ]);
    $stmt->close();
}

function collectMission($conn, $user_id) {
    $mission_id = $_POST['mission_id'] ?? 0;
    
    if (!$mission_id) {
        echo json_encode(['success' => false, 'message' => 'Mission ID required']);
        return;
    }
    
    // Start transaction
    $conn->begin_transaction();
    
    try {
        // Check if mission exists and get points value
        $sql = "SELECT points_value, mission_text FROM missions WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $mission_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 0) {
            throw new Exception('Mission not found');
        }
        
        $mission = $result->fetch_assoc();
        $points = $mission['points_value'];
        $mission_text = $mission['mission_text'];
        $stmt->close();
        
        // Check if user already completed this mission
        $sql = "SELECT id FROM user_missions WHERE user_id = ? AND mission_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $user_id, $mission_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            throw new Exception('Mission already completed');
        }
        $stmt->close();
        
        // Add mission to user_missions
        $sql = "INSERT INTO user_missions (user_id, mission_id, points_earned) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iid", $user_id, $mission_id, $points);
        $stmt->execute();
        $stmt->close();
        
        // Update user's total points
        $sql = "UPDATE users SET total_points = total_points + ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("di", $points, $user_id);
        $stmt->execute();
        $stmt->close();
        
        // Get updated total points
        $sql = "SELECT total_points FROM users WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $total_points = $user['total_points'];
        $stmt->close();
        
        $conn->commit();
        
        echo json_encode([
            'success' => true,
            'message' => 'Mission completed!',
            'points_earned' => number_format($points, 2, '.', ''),
            'total_points' => number_format($total_points, 2, '.', ''),
            'mission_text' => $mission_text
        ]);
        
    } catch (Exception $e) {
        $conn->rollback();
        echo json_encode([
            'success' => false,
            'message' => $e->getMessage()
        ]);
    }
}

function getPointHistory($conn, $user_id) {
    $sql = "SELECT um.points_earned, m.mission_text, um.completed_at 
            FROM user_missions um
            JOIN missions m ON um.mission_id = m.id
            WHERE um.user_id = ?
            ORDER BY um.completed_at DESC";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $history = [];
    while ($row = $result->fetch_assoc()) {
        $history[] = [
            'points' => number_format($row['points_earned'], 2, '.', ''),
            'description' => $row['mission_text'],
            'timestamp' => date('F j, Y g:i A', strtotime($row['completed_at']))
        ];
    }
    
    echo json_encode([
        'success' => true,
        'history' => $history
    ]);
    $stmt->close();
}

function getCompletedMissions($conn, $user_id) {
    $sql = "SELECT um.points_earned, m.mission_text, um.completed_at 
            FROM user_missions um
            JOIN missions m ON um.mission_id = m.id
            WHERE um.user_id = ?
            ORDER BY um.completed_at DESC";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $completed = [];
    while ($row = $result->fetch_assoc()) {
        $completed[] = [
            'points' => number_format($row['points_earned'], 2, '.', ''),
            'description' => $row['mission_text'],
            'timestamp' => date('F j, Y g:i A', strtotime($row['completed_at']))
        ];
    }
    
    echo json_encode([
        'success' => true,
        'completed' => $completed
    ]);
    $stmt->close();
}
?>