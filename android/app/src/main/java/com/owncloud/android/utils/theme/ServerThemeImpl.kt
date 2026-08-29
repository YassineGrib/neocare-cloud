/*
 * Nextcloud - Android Client
 *
 * SPDX-FileCopyrightText: 2022 Álvaro Brey <alvaro@alvarobrey.com>
 * SPDX-FileCopyrightText: 2022 Nextcloud GmbH
 * SPDX-License-Identifier: AGPL-3.0-or-later OR GPL-2.0-only
 */
package com.owncloud.android.utils.theme

import androidx.core.content.ContextCompat
import com.nextcloud.android.common.ui.color.ColorUtil
import com.nextcloud.android.common.ui.theme.ServerTheme
import com.owncloud.android.MainApp
import com.owncloud.android.R
import com.owncloud.android.lib.resources.status.OCCapability
import dagger.assisted.Assisted
import dagger.assisted.AssistedFactory
import dagger.assisted.AssistedInject

class ServerThemeImpl @AssistedInject constructor(colorUtil: ColorUtil, @Assisted capability: OCCapability) :
    ServerTheme {
    override val colorElement: Int
    override val colorElementBright: Int
    override val colorElementDark: Int
    override val colorText: Int
    override val primaryColor: Int

    init {
        val serverPrimaryColor =
            colorUtil.getNullSafeColorWithFallbackRes(capability.serverColor, R.color.primary)
        primaryColor = if (MainApp.isClientBranded()) {
            ContextCompat.getColor(MainApp.getAppContext(), R.color.primary)
        } else {
            serverPrimaryColor
        }
        colorElement = if (MainApp.isClientBranded()) {
            primaryColor
        } else {
            colorUtil.getNullSafeColor(capability.serverElementColor, primaryColor)
        }
        colorElementBright =
            colorUtil.getNullSafeColor(capability.serverElementColorBright, primaryColor)
        colorElementDark = colorUtil.getNullSafeColor(capability.serverElementColorDark, primaryColor)
        colorText = colorUtil.getTextColor(capability.serverTextColor, primaryColor)
    }

    @AssistedFactory
    interface Factory {
        fun create(capability: OCCapability): ServerThemeImpl
    }
}
