<?php

$db = mysqli_connect('localhost', 'root', '', 'cuciriobabang');
if (!$db) { 
    die('Connection failed: ' . mysqli_connect_error()); 
}

echo "=== TABLE STRUCTURES ===\n\n";

echo "📋 USERS table columns:\n";
$result = mysqli_query($db, 'DESCRIBE users');
if(!$result) {
    echo "  ❌ Table does not exist\n";
} else {
    while($row = mysqli_fetch_assoc($result)) {
        echo "  - " . $row['Field'] . " (" . $row['Type'] . ", " . ($row['Null']=='YES'?'nullable':'NOT NULL') . ")\n";
    }
}

echo "\n📋 BOOKINGS table columns:\n";
$result = mysqli_query($db, 'DESCRIBE bookings');
if(!$result) {
    echo "  ❌ Table does not exist\n";
} else {
    while($row = mysqli_fetch_assoc($result)) {
        echo "  - " . $row['Field'] . " (" . $row['Type'] . ", " . ($row['Null']=='YES'?'nullable':'NOT NULL') . ")\n";
    }
}

echo "\n📋 NOTIFICATIONS table columns:\n";
$result = mysqli_query($db, 'DESCRIBE notifications');
if(!$result) {
    echo "  ❌ Table does not exist\n";
} else {
    while($row = mysqli_fetch_assoc($result)) {
        echo "  - " . $row['Field'] . " (" . $row['Type'] . ", " . ($row['Null']=='YES'?'nullable':'NOT NULL') . ")\n";
    }
}

mysqli_close($db);
