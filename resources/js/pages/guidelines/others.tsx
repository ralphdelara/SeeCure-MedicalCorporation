export default function Others() {
    return (
        <>
            <h4>Others</h4>

            <h5>Clinical Safety Rules and Alerts</h5>
            <ul className="fs-4">
                <li>
                    <b>Patient Record Deletion</b>: 
                    Staff members must not delete any patient profile without explicit approval and
                    authorization from a System Administrator.
                </li>
                <li>
                    <b>Visit Record Deletion</b>: 
                    Front desk personnel may only delete a patient visit record if no clinical, diagnostic, 
                    or billing data has been recorded by other departments for that visit. 
                    Front desk personnel must ask for administrator's permission to do so.
                </li>
                <li>
                    <b>Strict Role Boundaries</b>: 
                    Users are strictly prohibited from creating duplicate accounts or requesting credentials 
                    under another department just to gain unauthorized access to restricted modules.
                </li>
                <li>
                    <b>Duplicate Patient Prevention</b>: 
                    Before creating a new patient profile, front desk staff must search existing records by 
                    name to prevent duplicate medical histories.
                </li>
                <li>
                    <b>Clinical Order Verification</b>: 
                    Departments (Laboratory, Radiology, and Pharmacy) must only process tests or dispense 
                    medications based on verified orders logged in the system by an authorized physician.
                </li>
            </ul>

            <h5>Audit Trails and Data Security</h5>
            <ul className="fs-4">
                <li>
                    <b>Always Save before anything else</b>: 
                    To prevent data loss, user need to press Save first before completing or navigating 
                    to other features to ensure the data is updated.
                </li>
                <li>
                    <b>Manual Logout Policy</b>: 
                    Because user sessions remain active on workstations until manually ended, 
                    staff members are strictly required to log out after finishing their shift or leaving a 
                    terminal unattended to prevent unauthorized data tampering.
                </li>
                <li>
                    <b>Comprehensive Audit Logging</b>: 
                    Every action performed across all modules—including adding, viewing, updating, 
                    or deleting records in Front Desk, Users, Consultation, Patients, Laboratory, 
                    Radiology, Pharmacy, Billing, Cashier, Admission, and Emergency Room—is 
                    automatically recorded in the Audit Log tab with user details and timestamps.
                </li>
                <li>
                    <b>Data-at-Rest Encryption</b>: 
                    Sensitive patient information is encrypted in the database using AES-256-GCM, 
                    ensuring that raw records remain unreadable to unauthorized parties unless accessed 
                    through an authenticated system session.
                </li>
                <li>
                    <b>Brute-Force Protection</b>: 
                    The login endpoint enforces a strict rate limit of 5 attempts per minute per user or IP 
                    address to block automated password-guessing attacks.
                </li>
                <li>
                    <b>Access Revocation</b>: 
                    System Administrators must immediately deactivate user accounts when a staff member 
                    resigns, transfers departments, or goes on extended leave.
                </li>
            </ul>

            <h5>Downtime Procedures and Troubleshooting</h5>
            <ul className="fs-4">
                <li>
                    <b>Manual Paper Fallback</b>: 
                    Because patient care cannot stop during IT outages, infirmary staff must immediately 
                    switch to standardized paper downtime forms for triage, prescriptions, lab requests, and 
                    billing receipts if a server or network failure occurs.
                </li>
                <li>
                    <b>Post-Outage Data Reconciliation</b>: 
                    Once network or server connectivity is restored, designated staff from each department must 
                    encode all paper records into the system in chronological order to keep patient histories and 
                    billing accurate.
                </li>
                <li>
                    <b>IT Escalation Protocol</b>: 
                    Staff must immediately contact the IT support team to diagnose and resolve network outages, 
                    server failures, application bugs, system errors, or workstation crashes.
                </li>
                <li>
                    <b>Automated Database Backups</b>: 
                    The local server performs scheduled daily backups of the encrypted database to prevent 
                    permanent data loss during hardware failures.
                </li>
            </ul>
        </>
    );
}