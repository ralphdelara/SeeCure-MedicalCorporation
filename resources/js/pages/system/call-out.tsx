import { Head } from '@inertiajs/react';
import { Breadcrumbs } from '@/components/breadcrumbs';
import { Button } from '@/components/ui/button';
import logo from '@/assets/images/logos/logo_text.png';
import { useEffect, useState } from 'react';
import {
    IconCalendar,
    IconClock,
    IconFlask,
    IconReportMoney,
    IconScan,
    IconStethoscope,
} from '@tabler/icons-react';
import '@/assets/css/call-out.css';
import Notification from './call-out-notification';

export default function CallOut() {
    const [calledDepartment, setCalledDeparment] = useState({
        name: 'Consultation',
        patient: '',
    });
    const [dateString, setDateString] = useState('-');
    const [timeString, setTimeString] = useState('--:--:--');

    const departments = [
        {
            name: 'Consultation',
            icon: <IconStethoscope />,
            grad: 'grad-sky',
            ring: 'ring-sky',
            chip: 'chip-sky',
        },
        {
            name: 'Laboratory',
            icon: <IconFlask />,
            grad: 'grad-violet',
            ring: 'ring-violet',
            chip: 'chip-violet',
        },
        {
            name: 'Radiology',
            icon: <IconScan />,
            grad: 'grad-rose',
            ring: 'ring-rose',
            chip: 'chip-rose',
        },
        {
            name: 'Cashier',
            icon: <IconReportMoney />,
            grad: 'grad-emerald',
            ring: 'ring-emerald',
            chip: 'chip-emerald',
        },
    ];

    const formatDate = () => {
        const date = new Date();
        const formattedDate = new Intl.DateTimeFormat('en-US', {
            weekday: 'long', // "Sunday"
            month: 'long', // "August"
            day: 'numeric', // "30" (or use '2-digit' for "30")
        }).format(date);

        let hours = date.getHours();
        const ampm = hours >= 12 ? 'pm' : 'am';
        hours = hours % 12;
        hours = hours ? hours : 12; // the hour '0' should be '12'
        const strHours = String(hours).padStart(2, '0');

        const minutes = String(date.getMinutes()).padStart(2, '0');

        const seconds = String(date.getSeconds()).padStart(2, '0');

        setDateString(formattedDate);
        setTimeString(`${strHours}:${minutes}:${seconds} ${ampm.toUpperCase()}`);
    };

    useEffect(() => {
        setInterval(() => {
            formatDate();
        }, 1000);
    }, []);

    return (
        <>
            <Head title="Call Out" />
            <Notification />
            <section id="view-display" className="view active">
                <div className="display">
                    <div className="display-head">
                        <div className="left">
                            <div>
                                <img src={logo} alt="logo" style={{ width: '300px' }} />
                            </div>
                        </div>
                        <div className="clock">
                            <div className="time" id="clock">
                                {timeString}
                            </div>
                            <div className="date" id="date">
                                {dateString}
                            </div>
                        </div>
                    </div>
                    <div className="grid" id="display-grid">
                        <div className="now-calling">
                            <div className="calling-label">
                                <span className="pulse">
                                    <span className="ping"></span>
                                    <span></span>
                                </span>
                                Now Calling
                            </div>
                            {calledDepartment.name !== '' && (
                                <>
                                    <div className="dept-chip">
                                        {calledDepartment.icon} {calledDepartment.name}
                                        <span className="num">#1</span>
                                    </div>
                                    <h2 className="patient-name text-white">{'Maria Santos'}</h2>
                                    <p className="proceed">
                                        Please proceed to {calledDepartment.name}
                                    </p>
                                </>
                            )}
                            {calledDepartment.name === '' && (
                                <div className="empty">
                                    <h2>No patient is being called</h2>
                                    <p>Waiting for the next call…</p>
                                </div>
                            )}
                        </div>
                        {departments.map((item, index) => (
                            <div
                                className={
                                    'dept-card ' +
                                    item.ring +
                                    (item.name === calledDepartment.name ? ' active' : '')
                                }
                                key={'callOut-department-' + index}
                            >
                                <div className="dept-top">
                                    <div className={'dept-icon ' + item.grad}>{item.icon}</div>
                                    <span className="dept-name">{item.name}</span>
                                </div>
                                <div className="dept-body">
                                    <div className="lbl">Latest Called</div>
                                    <div className="name">Ralph Randahl De Lara</div>
                                    <div className="qnum">#1</div>
                                </div>
                            </div>
                        ))}
                    </div>
                </div>
            </section>
        </>
    );
}
