
import outpatientImg from '@/assets/images/guidelines/outpatient.png';
import { IconChevronRight } from '@tabler/icons-react';

export default function OutPatientFlow() {
    const iconRight = <IconChevronRight />

    return (
        <>
            <h4>OutPatient</h4>
            <img src={outpatientImg} />
            <ul className="fs-4">
                <li>
                    <b>Outpatient (Consultation Only)</b>
                    <div>
                        Front Desk {iconRight} Queue Patient {iconRight} Consultation {iconRight} Billing {iconRight} Cashier {iconRight} Done
                    </div>
                </li>
                <li>
                    <b>Outpatient (Laboratory Only)</b>
                    <div>
                        Front Desk {iconRight} Queue Patient {iconRight} Billing {iconRight} Cashier {iconRight} Laboratory {iconRight} Done
                    </div>
                    <small>Walk-In Patient Data will be removed and the lab or radio data will be treated as <b>Walk-In Patient</b></small>
                </li>
                <li>
                    <b>Outpatient (Radiology Only)</b>
                    <div>
                        Front Desk {iconRight} Queue Patient {iconRight} Billing {iconRight} Cashier {iconRight} Radiology {iconRight} Done
                    </div>
                    <small>Walk-In Patient Data will be removed and the lab or radio data will be treated as <b>Walk-In Patient</b></small>
                </li>
                <li>
                    <b>Outpatient (Consultation with Laboratory)</b>
                    <div>
                        Front Desk {iconRight} Queue Patient {iconRight} Billing (Laboratory) {iconRight} Cashier {iconRight}
                        Laboratory {iconRight} Consultation {iconRight} Billing (Consultation) {iconRight} Cashier {iconRight} Done
                    </div>
                </li>
                <li>
                    <b>Outpatient (Consultation with Radiology)</b>
                    <div>
                        Front Desk {iconRight} Queue Patient {iconRight} Billing (Radiology) {iconRight} Cashier {iconRight}
                        Radiology {iconRight} Consultation {iconRight} Billing (Consultation) {iconRight} Cashier {iconRight} Done
                    </div>
                </li>
                <li>
                    <b>Outpatient (Consultation with Laboratory and Radiology)</b>
                    <div>
                        Front Desk {iconRight} Queue Patient {iconRight} Billing (Laboratory and Radiology) {iconRight} Cashier {iconRight}
                        Laboratory {iconRight} Radiology {iconRight} Consultation {iconRight} Billing (Consultation) {iconRight} Cashier {iconRight} Done
                    </div>
                </li>
                <li>
                    <b>Outpatient (Consultation only but Doctor added Laboratory or Radiology Request)</b>
                    <div>
                        Front Desk {iconRight} Queue Patient {iconRight} Consultation {iconRight}
                        Doctor Added Laboratory or Radiology Request {iconRight} Billing (Laboratory or Radiology) {iconRight} Cashier
                        {iconRight} Laboratory or Radiology {iconRight} Consultation {iconRight} Billing (Consultation) {iconRight} Cashier {iconRight} Done
                    </div>
                </li>
                <li>
                    <b>Outpatient (After Consultation with available drug)</b>
                    <div>
                        Pharmacy {iconRight} Cashier {iconRight} Done
                    </div>
                    <small>
                        Pharmacy can delete the pharmacy record if patient dont want to purchase
                    </small>
                </li>
            </ul>
        </>
    );
}