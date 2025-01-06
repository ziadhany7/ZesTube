# Video Display Site Project

## Overview

This project is a video display website, similar to YouTube, developed using PHP, HTML, JavaScript, and CSS. It was built following the Model-View-Controller (MVC) architecture, ensuring a clean separation of concerns and an organized codebase. The project incorporates basic software development principles to create a functional and user-friendly platform for hosting and sharing videos.

## Features

- **User Authentication**:

  - User registration and login.
  - Password recovery and account management.

- **Video Management**:

  - Upload videos with metadata (title, description, tags, etc.).
  - Categorize videos for easy browsing.
  - Edit or delete uploaded videos.

- **Video Playback**:

  - Stream videos with playback controls (play, pause, volume, fullscreen, etc.).
  - Adjust video quality based on user preferences.

- **User Interaction**:

  - Like, dislike, and comment on videos.
  - Subscribe to channels and receive notifications.
  - Share videos via social media or embed links.

- **Search and Navigation**:

  - Advanced search functionality with filters (e.g., category, upload date, popularity).
  - Recommended videos based on user activity and preferences.

- **Admin Dashboard**:

  - Manage users, videos, and site settings.
  - Monitor site analytics (e.g., number of views, user engagement).

## Technologies Used

- **Backend**: PHP
- **Frontend**: HTML, CSS, JavaScript
- **Database**: MySQL (for storing user data, video information, and comments)
- **MVC Framework**: Custom-built or a lightweight PHP framework

## Installation

1. Clone the repository:

   ```bash
   git clone [https://github.com/ziadhany7/ZesTube]
   ```

2. Set up the database:

   - Import the provided SQL file (`database.sql`) into your MySQL server.
   - Update the database credentials in the `config` file.

3. Configure the environment:

   - Edit the `.env` file to set environment variables (e.g., base URL, database settings).

4. Start the development server:

   ```bash
   php -S localhost:8000
   ```

5. Access the site at `http://localhost:8000` in your browser.

## Usage

- **Uploading Videos**: Navigate to the upload page, fill in the required fields, and submit your video.
- **Searching for Videos**: Use the search bar to find videos by title, category, or tags.
- **Interacting with Content**: Like, comment, and share videos as desired.
- **Admin Functions**: Access the admin dashboard to manage users and content.

## Future Enhancements

- Implement live streaming functionality.
- Add advanced analytics for content creators.
- Improve video encoding and compression for faster loading.
- Introduce dark mode for better user experience.

## Contributing

Contributions are welcome! Please fork the repository and submit a pull request with your changes.

## License

This project is licensed under the MIT License. See the `LICENSE` file for details.

## Contact

For any inquiries or support, feel free to contact me at [[ziadhanywadea5@gmail.com](mailto\:ziadhanywadea5@gmail.com)].

