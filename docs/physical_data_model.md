# Physical Data Model - Vehicle Booking System

## Entity Relationship Diagram

```
┌─────────────────┐        ┌─────────────────┐
│     Regions     │1      n│      Users      │
│                 │◄──────►│   (Admin/Supp/  │
│ - id            │        │  Manager/Driver)│
│ - name          │        │ - id            │
│ - type          │        │ - username      │
│ - location      │        │ - email         │
└─────────────────┘        │ - password      │
                           │ - role          │
                           └─────────────────┘
                                     │1
                                     │n
                           ┌─────────────────┐
                           │    Vehicles     │1
                           │ - id            │◄──────►n│ MaintenanceSchedules│
                           │ - license_plate │        │ - vehicle_id       │
                           │ - brand         │        │ - scheduled_date   │
                           │ - status        │        │ - maintenance_type │
                           │ - region_id     │        │ - status           │
                           └─────────────────┘        └──────────────────┘
                                     │1                        │
                                     │n                        │n
                           ┌─────────────────┐        ┌─────────────────┐
                           │     Bookings    │◄──────►│     FuelLogs    │
                           │ - id            │        │ - vehicle_id    │
                           │ - booking_number│        │ - booking_id    │
                           │ - vehicle_id    │        │ - fuel_amount   │
                           │ - driver_id     │        │ - odometer      │
                           │ - requester_id  │        │ - created_by    │
                           │ - status        │        └─────────────────┘
                           │ - start_date    │
                           └─────────────────┘
                                     │1
                                     │n
                           ┌─────────────────┐
                           │ ApprovalHistory │
                           │ - booking_id    │
                           │ - approver_id   │
                           │ - level         │
                           │ - status        │
                           │ - notes         │
                           └─────────────────┘
```

## Table Details

### 1. users
```
id, username, email, password, full_name, nip, position, region_id, role, is_active
```

### 2. regions
```
id, name, type, location
```

### 3. vehicles
```
id, license_plate, brand, model, type, ownership, region_id, fuel_consumption, status
```

### 4. bookings
```
id, booking_number, vehicle_id, driver_id, approver_level_1_id, approver_level_2_id, requester_id, purpose, start_date, end_date, status, rejection_reason
```

### 5. approval_history
```
id, booking_id, approver_id, approval_level, status, notes
```

### 6. application_logs
```
id, user_id, action, description, ip_address, user_agent
```

### 7. fuel_logs
```
id, vehicle_id, booking_id, fuel_amount, fuel_cost, odometer, created_by
```

### 8. maintenance_schedules
```
id, vehicle_id, scheduled_date, maintenance_type, notes, status, created_by
```



