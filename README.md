# WP Recursive Permission Changer

The WP Recursive Permission Changer is a tool designed to modify file and directory permissions recursively on your WordPress website. This can be helpful in various situations where you need to adjust permissions quickly and efficiently.

![pic](https://github.com/paperbonsai/wp-recursive-permission-changer/assets/5368491/65041494-c7db-41f2-b695-20dfe6cd1a1b)

## Usage Instructions

Follow these steps to use the WP Recursive Permission Changer:

1. **Download the 'chmod' Directory:**

   - Download the 'chmod' directory provided with the script.

2. **Access Your Website's Root Directory:**

   - Connect to your website's server using FTP or a file manager provided by your hosting service.

3. **Upload the 'chmod' Directory:**

   - Upload the entire 'chmod' directory to the root directory of your website. This is typically the directory where your website's main files, like 'index.php' or 'wp-config.php,' are located.

4. **Access the Script Interface:**

   - Open a web browser and navigate to the URL where you placed the 'chmod' directory. For example, if your website is 'https://www.yourwebsite.com,' and you placed 'chmod' in the root directory, access it at 'https://www.yourwebsite.com/chmod/'.

5. **Set Directory and File Permissions:**

   - In the script interface, you'll see two input fields:
     - **Directory Permissions:** Enter the desired permissions for directories in numeric format (e.g., 755).
     - **File Permissions:** Enter the desired permissions for files in numeric format (e.g., 644).

6. **Start the Permission Change Process:**

   - Click the "Start" button to initiate the permission change process.

7. **Monitor Progress:**

   - The progress bar will show the percentage of completion. The script will recursively change permissions for all directories and files in the root directory and its subdirectories.

8. **Process Completion:**

   - Once the process is complete, the summary of the total items processed and the time taken will be displayed.

9. **Finished:**

   - You have successfully used the WP Recursive Permission Changer script to modify permissions for directories and files on your website.

10. **Note:**

    - This script is a powerful tool for managing permissions, so use it with caution. Incorrect permission settings can affect the functionality of your website. Always ensure you have a backup of your website before making significant changes.

## Removal

When you have completed the permission changes, it's recommended to remove the 'chmod' directory from your hosting for security reasons.

## Contributing

If you'd like to contribute to this project, please feel free to fork the repository, make your changes, and submit a pull request.

## Issues and Support

If you encounter any issues or have questions about using this tool, please open an issue in the GitHub repository. We'll do our best to provide assistance.

