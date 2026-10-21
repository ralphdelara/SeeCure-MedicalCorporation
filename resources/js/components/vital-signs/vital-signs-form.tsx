import { usePage } from '@inertiajs/react';
import React from 'react';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import type { VitalSigns, VitalSignsFormProps } from '@/components/vital-signs/vital-signs';

interface InertiaProps {
    vitalSigns: VitalSigns[];
}

const VitalSignsForm = ({ data, setData }: VitalSignsFormProps) => {
    const { vitalSigns } = usePage().props as unknown as InertiaProps;

    const setVitalSignData = (
        e: React.ChangeEvent<HTMLInputElement>,
        id: number,
        fieldId: number,
    ) => {
        const vitalSignsData = { ...data.vital_signs };

        if (!vitalSignsData[id]) {
            vitalSignsData[id] = {};
        }

        vitalSignsData[id][fieldId] = e.target.value;

        setData('vital_signs', vitalSignsData);
    };

    return (
        <section role="tabpanel" className="body current mb-3">
            <Label className="form-label fs-5">Vital Signs</Label>
            <div className="row g-1">
                {vitalSigns.map((item, index) => {
                    const vitalSign = data.vital_signs[item.id];

                    return (
                        <div className="col-md-6" key={'vsigns-' + index}>
                            <div className="form-group">
                                <Label htmlFor={item.name.replace(' ', '_')} className="form-label">
                                    {item.name}
                                </Label>
                                <div>
                                    {item.fields.map((itemField, indexField) => {
                                        let vitalSignData: string | number = '';

                                        if (vitalSign && vitalSign[itemField.id]) {
                                            vitalSignData = vitalSign[itemField.id];
                                        }

                                        return (
                                            <div
                                                className="input-group"
                                                key={'queue-vsigns-' + indexField + '-' + index}
                                            >
                                                <Input
                                                    type="number"
                                                    min="1"
                                                    key={
                                                        itemField.name.replace(' ', '_') +
                                                        indexField
                                                    }
                                                    placeholder={itemField.name}
                                                    onChange={(e) =>
                                                        setVitalSignData(e, item.id, itemField.id)
                                                    }
                                                    value={vitalSignData}
                                                    step="0.001"
                                                />
                                                <span className="input-group-text">
                                                    {itemField.unit}
                                                </span>
                                            </div>
                                        );
                                    })}
                                </div>
                            </div>
                        </div>
                    );
                })}
            </div>
        </section>
    );
};

export default VitalSignsForm;
