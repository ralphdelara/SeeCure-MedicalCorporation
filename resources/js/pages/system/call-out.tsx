import { Head, Link } from '@inertiajs/react';
import logo from '@/assets/images/logos/logo_text.png';
import { useEffect, useRef, useState } from 'react';
import {
    IconArrowsMaximize,
    IconArrowsMinimize,
    IconFlask,
    IconReportMoney,
    IconScan,
    IconStethoscope,
} from '@tabler/icons-react';
import '@/assets/css/call-out.css';
import { echo } from '@/components/echo';
import notificationSound from '@/assets/sounds/ding-dong.mp3';
import { useSpeech } from 'react-text-to-speech';
import { dashboard } from '@/routes';

export default function CallOut() {
    const [speechText, setSpeechText] = useState('');
    const [maximize, setMaximize] = useState(false);
    const startButtonRef = useRef<HTMLButtonElement>(null);
    const [blinkText, setBlinkText] = useState('blink');

    const { Text, speechStatus, start, pause, stop } = useSpeech({
        text: speechText.split('|')[0],
        pitch: 1,
        rate: 0.9,
        volume: 1,
        lang: 'en-US',
        voiceURI: 'Google US English',
        autoPlay: false,
        highlightText: true,
        showOnlyHighlightedText: false,
        highlightMode: 'word',
        enableDirectives: false,
    });

    const [calledDepartment, setCalledDepartment] = useState({
        department: '',
        patientName: '',
    });
    const [dateString, setDateString] = useState('-');
    const [timeString, setTimeString] = useState('--:--:--');
    const [lastCalled, setLastCalled] = useState({
        Consultation: '',
        Laboratory: '',
        Radiology: '',
        Cashier: '',
    });

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
            weekday: 'long',
            month: 'long',
            day: 'numeric',
        }).format(date);

        let hours = date.getHours();
        const ampm = hours >= 12 ? 'pm' : 'am';
        hours = hours % 12;
        hours = hours ? hours : 12;
        const strHours = String(hours).padStart(2, '0');
        const minutes = String(date.getMinutes()).padStart(2, '0');
        const seconds = String(date.getSeconds()).padStart(2, '0');

        setDateString(formattedDate);
        setTimeString(`${strHours}:${minutes}:${seconds} ${ampm.toUpperCase()}`);
    };

    useEffect(() => {
        const timer = setInterval(() => {
            formatDate();
        }, 1000);
        return () => clearInterval(timer);
    }, []);

    const playSound = async () => {
        const audio = new Audio(notificationSound);
        try {
            await audio.play();
        } catch (e) {
            if (e instanceof Error) {
                console.error(e.message);
                console.error(e.stack);
            } else {
                console.error('An unexpected error occurred:', e);
            }
        }
    };

    useEffect(() => {
        const channel = echo.channel('call-out');

        channel.listen('CallOut', (e: { patientName: string; department: string }) => {
            playSound();

            setCalledDepartment({
                patientName: e.patientName,
                department: e.department,
            });

            setLastCalled((prev) => ({
                ...prev,
                [e.department]: e.patientName,
            }));

            // adding date ensures the call out will talk even with same patient name and department name
            setSpeechText(
                `Patient ${e.patientName}, please proceed to ${e.department}. NOW!!!!|${new Date()}`,
            );

            setBlinkText('blink');

            setTimeout(() => {
                setBlinkText('');
            }, 6000);
        });

        return () => {
            echo.leaveChannel('call-out');
        };
    }, []);

    useEffect(() => {
        setTimeout(() => {
            if (startButtonRef.current) {
                startButtonRef.current?.click();
            }
        }, 1500);
        console.log(speechStatus);
    }, [speechText]);

    const toggleMaximize = async (isMaximize: boolean) => {
        setMaximize(isMaximize);

        try {
            if (isMaximize) {
                // Only request if not already full screen
                if (!document.fullscreenElement) {
                    await document.documentElement.requestFullscreen();
                }
            } else {
                // CRITICAL FIX: Only exit if there is an active element to exit from
                if (document.fullscreenElement) {
                    await document.exitFullscreen();
                }
            }
        } catch (error) {
            // Handle cases where the browser blocks the action
            console.error('Fullscreen toggle failed:', error);

            // Rollback state if the browser blocked the action
            setMaximize(false);
        }
    };

    return (
        <>
            <Head title="Call Out" />
            <div className="hidden">
                <button ref={startButtonRef} onClick={start}>
                    Start
                </button>
            </div>
            <section id="view-display" className="view active">
                <div className="display">
                    <div className="display-head">
                        <div className="left">
                            <div>
                                <Link href={dashboard().url}>
                                    <img src={logo} alt="logo" style={{ width: '300px' }} />
                                </Link>
                            </div>
                            {!maximize && (
                                <IconArrowsMaximize
                                    onClick={() => toggleMaximize(true)}
                                    className="cursor-pointer"
                                />
                            )}
                            {maximize && (
                                <IconArrowsMinimize
                                    onClick={() => toggleMaximize(false)}
                                    className="cursor-pointer"
                                />
                            )}
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
                            {calledDepartment.department !== '' && (
                                <>
                                    <div className="dept-chip">
                                        {calledDepartment.department}
                                        <span className="num">#1</span>
                                    </div>
                                    <h2 className={'patient-name text-white ' + blinkText}>
                                        {calledDepartment.patientName}
                                    </h2>
                                    <p className="proceed">
                                        Please proceed to {calledDepartment.department}
                                    </p>
                                </>
                            )}
                            {calledDepartment.department === '' && (
                                <div className="empty">
                                    <h2 className="text-white">No patient is being called</h2>
                                    <p>Waiting for the next call…</p>
                                </div>
                            )}
                        </div>
                        {departments.map((item, index) => (
                            <div
                                className={
                                    'dept-card ' +
                                    item.ring +
                                    (item.name === calledDepartment.department ? ' active' : '')
                                }
                                key={'callOut-department-' + index}
                            >
                                <div className="dept-top">
                                    <div className={'dept-icon ' + item.grad}>{item.icon}</div>
                                    <span className="dept-name">{item.name}</span>
                                </div>
                                {lastCalled[item.name as keyof typeof lastCalled] !== '' ? (
                                    <div className="dept-body">
                                        <div className="lbl">Latest Called</div>
                                        <div className="name">
                                            {lastCalled[item.name as keyof typeof lastCalled]}
                                        </div>
                                        <div className="qnum">#1</div>
                                    </div>
                                ) : (
                                    <div className="dept-body dept-empty mt-5">
                                        <div className="name">No call yet</div>
                                        <div className="sub">Awaiting patients…</div>
                                    </div>
                                )}
                            </div>
                        ))}
                    </div>
                </div>
            </section>
        </>
    );
}
