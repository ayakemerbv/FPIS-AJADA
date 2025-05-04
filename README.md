# API Documentation

## Authentication
- **POST /** - Login to the system
- **POST /logout** - Logout from the system (requires authentication)

## Admin Panel
*Requires authentication and admin role*

### User Management
- **GET /admin/dashboard/users/create** - Display user creation form
- **POST /admin/dashboard/users** - Create new user
- **GET /admin/dashboard/users** - List all users
- **DELETE /admin/dashboard/users/{id}** - Delete user
- **GET /admin/users/{id}/json** - Get user information in JSON format

## Student Panel
*Requires authentication and student role*

### Profile and Personal Account
- **GET /student/dashboard** - Student dashboard
- **GET /student/personal** - Personal account
- **POST /student/personal/profile/update** - Update profile
- **PATCH /student/personal/profile/update** - Update profile details

### Marketplace
- **GET /student/ads** - View advertisements
- **POST /student/ads** - Create advertisement
- **PUT /student/ads/{ad}** - Update advertisement
- **DELETE /student/ads/{ad}** - Delete advertisement

### Room Booking
- **GET /student/personal/floors/{building_id}** - Get list of floors in building
- **GET /student/personal/rooms/{building_id}/{floor}** - Get list of rooms
- **POST /student/personal/booking/store** - Create booking
- **POST /student/personal/booking/change-room** - Change room

### Payments
- **POST /payment/initiate** - Initialize payment
- **GET /payment/callback** - Payment system callback
- **GET /payment/status/{id}** - Check payment status

### Maintenance Requests
- **GET /personal/create-request** - Display request creation form
- **POST /personal** - Create request
- **GET /personal/requests** - List requests
- **GET /personal/requests/{id}** - View request details
- **PUT /personal/requests/{repairRequest}** - Update request
- **DELETE /personal/requests/{repairRequest}** - Delete request

## Employee Panel
*Requires authentication and employee role*

### Request Management
- **GET /employee/dashboard/requests** - List requests
- **GET /employee/dashboard/requests/{id}** - View request details
- **PUT /employee/dashboard/requests/{id}** - Update request status

## Common Endpoints
- **POST /language-switch** - Switch language
- **GET /notifications** - Get notifications
- **POST /notifications/{id}/read** - Mark notification as read

## Response Format

### Success Response
