import inpatientImg from '@/assets/images/guidelines/inpatient.png';
import { IconChevronRight } from '@tabler/icons-react';

export default function InPatientFlow() {
    const iconRight = <IconChevronRight />

    return (
        <>
            <h4>InPatient *Not yet implemented</h4>
            <img src={inpatientImg} />
            <ul className="fs-4">
                <li>
                    <b>InPatient (Admission) *Not yet implemented</b>
                    <div>
                        Front Desk or Emergency Room {iconRight}
                        Consultation Or Emergency Doctor {iconRight}
                        Doctor selects Ward(Bed) {iconRight}
                        Patient Status will be set to Admitted {iconRight}
                        Doctor can add order sheet {iconRight}
                        Doctor will perform daily rounds {iconRight}
                        Doctor can add order sheet for daily rounds {iconRight}
                        Doctor or Nurse can select Discharge {iconRight}
                        Billing {iconRight}
                        Cashier {iconRight}
                        Discharged
                    </div>
                </li>
            </ul>
        </>
    );
}