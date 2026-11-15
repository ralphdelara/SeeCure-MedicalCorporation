import TableList from "@/components/table";

export default function SystemRequirementsAndSetup() {
    const header = [
        { name: 'Component', align: 'left' },
        { name: 'Client Workstation', align: 'left' },
        { name: 'Server', align: 'left' },
    ];

    return (
        <>
            <h4>System Requirements and Setup</h4>
            <h5>1. Hardware & Software Specifications Table</h5>
            <TableList header={header} hasPage={false}>
                <tr>
                    <td>Operating System</td>
                    <td>Windows 10/11</td>
                    <td>Windows 10/11</td>
                </tr>
                <tr>
                    <td>Processor (CPU)</td>
                    <td>Intel Core i3 / AMD Ryzen 3 or higher</td>
                    <td>Intel Core i3 / AMD Ryzen 3 or higher</td>
                </tr>
                <tr>
                    <td>Memory (RAM)</td>
                    <td>
                        Minimum 4 GB
                    </td>
                    <td>
                        Minimum 16 GB - 32 GB
                    </td>
                </tr>
                <tr>
                    <td>Storage</td>
                    <td>
                        256 GB SSD
                    </td>
                    <td>
                        1TB+ NVMe SSD
                    </td>
                </tr>
                <tr>
                    <td>Browser / Software</td>
                    <td>
                        <ul>
                            <li>Chrome</li>
                            <li>Edge</li>
                            <li>Firefox</li>
                        </ul>
                    </td>
                    <td>
                        <ul className="fs-4">
                            <li>Internet Information Services (web server)</li>
                            <li>HTML, CSS, Javascript (front end)</li>
                            <li>PHP 8.3 (back end)</li>
                            <li>Laravel 13 (framework)</li>
                            <li>Laravel Reverb (web-sockets)</li>
                            <li>React with Typescript (framework)</li>
                            <li>PostgreSQL (database)</li>
                            <li>VS Code (code editor)</li>
                            <li>NSSM (automation and scheduler)</li>
                            <li>GitHub Runner (deployment to self hosted server)</li>
                        </ul>
                    </td>
                </tr>
                <tr>
                    <td>Peripherals</td>
                    <td>Printer</td>
                    <td>N/A</td>
                </tr>
            </TableList>

            <h5 className="mt-3">2. Network & Connectivity Requirements</h5>
            <ul className="fs-4">
                <li>
                    <b>Local Area Network (LAN)</b>:
                    The system operates exclusively within the infirmary's internal Local Area Network (LAN)
                    without relying on an external internet connection for core daily operations.
                </li>
                <li><b>Bandwidth & Stability</b>:
                    A minimum network or internet speed of 25 Mbps or higher is required to ensure smooth real-time data
                    synchronization across all departments.
                </li>
                <li>
                    <b>Security & Firewall</b>:
                    All network traffic is secured using HTTPS/SSL encryption configured on port 443,
                    while sensitive patient records are protected at rest using AES-256-GCM encryption.
                </li>
            </ul>

            <h5>3. Initial Setup & Access Instructions</h5>
            <ul className="fs-4">
                <li>
                    <b>Server/Application Deployment</b>:
                    The software is hosted locally on an on-premise server and is automatically deployed
                    and updated through a self-hosted GitHub Actions runner.
                </li>
                <li>
                    <b>Workstation Configuration</b>:
                    Setup requires generating SSL certificates on the server, installing those trusted
                    certificates on each client workstation, and configuring local drivers for printing
                    prescriptions, laboratory results, radiology reports, billing, picklists, and receipts.
                    Because the system is built as a Progressive Web App (PWA), staff only need to open a web
                    browser, enter the server's IP address, and click install once, as all future updates
                    automatically reflect across every workstation upon deployment.
                </li>
                <li>
                    <b>First-Time Login</b>:
                    Default departmental user accounts are automatically seeded into the database immediately
                    after deployment through automated php artisan commands executed by the GitHub runner.
                </li>
            </ul>
        </>
    );
}